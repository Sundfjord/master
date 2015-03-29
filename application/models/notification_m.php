<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_m extends MY_Model {
    function __construct() {
        parent::__construct();
    }

    /**
     * Save notifications
     *
     * This function saves notifications in DB which will be fetched
     * and shown to users periodically.
     *
     * @param int $type The type of notification to save
     * @param int $creator_id User id of user that 'caused' the notifications
     * @param int $team_id The team that the notifications concerns
     * @param mixed $detail Optional variable that represents a detail to be presented in notification
     * @param mixed $detail2 Optional variable that represents a detail to be presented in notification
     *
     * @return void
     */
    public function saveNotifications($type, $creator_id, $team_id, $detail = false, $detail2 = false)
    {
        // Find the notification creator's username
        $this->db->select('id, username')->from('users')->where('id', $creator_id);
        $userquery = $this->db->get();
        if ($userquery->num_rows() > 0) {
            $userinfo = $userquery->row();
            $username = $userinfo->username;
        }
        // Find teamname of team the notification concerns
        $this->db->query('SELECT id, teamname FROM teams WHERE id='.$team_id);
        $this->db->select('id, teamname')->from('teams')->where('id', $team_id);
        $teamquery = $this->db->get();
        if ($teamquery->num_rows() > 0) {
            $teaminfo = $teamquery->row();
            $teamname = $teaminfo->teamname;
        }

        // Find what message we want to send based on the type provided
    	switch($type){
            # Notifications for players
            case 1: # Team name change
                $message = $username . ' changed the name of your team ' . $detail2 . ' to ' . $teamname . '.';
            break;
            case 2: # Sport change
                $message = $username . ' changed the sport of your team ' . $teamname . ' to ' . $detail2 . '.';
            break;
            case 3: # Team name and sport change
                $message = $username . ' changed details for your team ' . $detail2 . '.';
            break;
            case 4: # Player joins team
                $message = $username . ' has joined ' . $teamname . ' as player.';
            break;
            case 5: # Events added to team
                $countString = $detail == 1 ? $detail . ' event' : $detail . ' events';
                $message = $username . ' added ' . $countString . ' to the ' . $teamname . ' calendar . ';
            break;
            case 6: # Event details changed
                $message = $username . ' changed the ' . $teamname . ' event ' . $detail2 . '.';
            break;
            case 7: # Episode details changed
                $message = $username . ' changed the details of the ' . $teamname . ' event ' . $detail2 . '.';
            break;
            # Notifications for coaches
            case 8: # Player left team
                $message = $username . ' left ' . $teamname . '.';
            break;
            case 9: # Player has requested to join team
                $message = $username . ' has requested to join ' . $teamname . '.';
            break;
            case 10: # Player attendance status changed
                $detailString = $detail == 1 ? 'attending' : 'not attending';
                $message = $username . ' is now ' . $detailString . ' the ' . $teamname . ' event ' . $detail2 . '.';
            break;
            case 11: # User added as coach for team
                $count = count($detail);
                $name = $detail[0];
                if ($count > 1) {
                    $name = $count . ' coaches';
                }
                $message = $username . ' added ' . $name . ' to ' . $teamname . '.';
            break;
        }

        $created = date('Y-m-d H:i:s');
        $seen = 0;
        $notificationInsert = array(
            'created'       => $created,
            'seen'          => $seen,
            'type'          => $type,
            'creator_id'    => $creator_id,
            'team_id'       => $team_id,
            'message'       => $message
            );

        // If we want to send notifications to players
        if ($type <= 7) {
            $this->db->select('user_id')->from('plays_for')->where('team_id', $team_id);
            $playerquery = $this->db->get();

            if ($playerquery->num_rows() > 0) {
                foreach($playerquery->result_array() as $row) {
                    // We rule out player coaches who caused the notification
                    if ($row['user_id'] != $creator_id) {
                        $notificationInsert['user_id'] = $row['user_id'];
                        $this->db->insert('notifications', $notificationInsert);
                    }
                }
            }
        } else {
            $this->db->select('user_id')->from('is_coach_of')->where('team_id', $team_id);
            $coachquery = $this->db->get();

            if ($coachquery->num_rows() > 0) {
                foreach($coachquery->result_array() as $row) {
                    // We rule out the coach who caused the notification
                    if ($row['user_id'] != $creator_id) {
                        $notificationInsert['user_id'] = $row['user_id'];
                        $this->db->insert('notifications', $notificationInsert);
                    }
                }
            }
        }
        return;
    }
    /**
     * Fetches notifications
     *
     * Function fetches notifications for a given user
     * and returns them to present them in a view
     *
     * @param int $user_id ID of the user we are looking for notifications for
     * @param boolean $all True if we want both seen and not seen notifications, false otherwise
     *
     * @return boolean True if results, false otherwise
     */
    public function getNotifications($user_id, $all = false)
    {
        //$this->db->select();
        $this->db->from('notifications');
        $this->db->where('user_id', $user_id);
        if (!$all) {
            $this->db->where('seen', 0);
        }
        $allnotifications = $this->db->get();

        if ($allnotifications->num_rows() > 0) {
            $notifications = array();
            foreach($allnotifications->result_array() as $row) {
                // Find the notification creator's username
                $this->db->select('id, username')->from('users')->where('id', $row['creator_id']);
                $creatorquery = $this->db->get();
                if ($creatorquery->num_rows() > 0) {
                    $creatorinfo = $creatorquery->row();
                    $creatorname = $creatorinfo->username;
                }

                // Find teamname of team the notification concerns
                $this->db->select('id, teamname')->from('teams')->where('id', $row['team_id']);
                $teamquery = $this->db->get();
                if ($teamquery->num_rows() > 0) {
                    $teaminfo = $teamquery->row();
                    $teamname = $teaminfo->teamname;
                }
                $notification = array(
                    'id'        => $row['id'],
                    'created'   => $row['created'],
                    'seen'      => $row['seen'],
                    'team_id'   => $row['team_id'],
                    'teamname'  => $teamname,
                    'creator'   => $creatorname,
                    'message'   => $row['message']
                    );
                array_push($notifications, $notification);
            }
        }
        if (!empty($notifications)) {
            return $notifications;
        } else {
            return false;
        }
    }

    public function markNotificationAsRead($id)
    {
        $this->db->set('seen', 1)->where('id', $id)->update('notifications');
        return true;
        //$this->db->where('user_id', $this->session->userdata('user_id'));
        //$this->db->update('attendance_status');
    }
}