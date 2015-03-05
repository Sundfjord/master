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
     * @param int $count Optional variable that represents a number to be presented in notification
     * @param string $detail Optional variable that represents a string to be presented in notification
     *
     * @return void
     */
    public function saveNotifications($type, $creator_id, $team_id, $count = false, $detail = false)
    {
        // Find the notification creator's username
        $this->db->select('id, username')->from('users')->where('id', $creator_id);
        $userquery = $this->db->get();
        if ($userquery->num_rows() > 0) {
            $userinfo = $userquery->row();
            $username = $userinfo->username;
        }
        // Find teamname of team the notification concerns
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
                $message = '';
            break;
            case 2: # Sport change
                $message = '';
            break;
            case 3: # Team name and sport change
                $message = '';
            break;
            case 4: # Player joins team
                $message = '';
            break;
            case 5: # Events added to team
                $countString = $count == 1 ? 'event' : 'events';
                $message = $count . ' ' . $countString . ' were added to the ' . $teamname . ' calendar by ' . $username . '.';
            break;
            case 6: # Event details changed
                $message = '';
            break;
            case 7: # Episode details changed
                $message = '';
            break;
                $message = '';
            # Notifications for coaches
            case 8: # Player left team
                $message = '';
            break;
            case 9: # Player has requested to join team
                $message = '';
            break;
            case 10: # Player attendance status changed
                $message = '';
            break;
            case 11: # User added as coach for team
                $message = '';
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
                    // We don't bother sending a player notification to player coaches
                    // who added the events themselves
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
                    $notificationInsert['user_id'] = $row['user_id'];
                    $this->db->insert('notifications', $notificationInsert);
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
     *
     * @return [type] [description]
     */
    public function getNotifications($user_id)
    {
        $this->db->from('notifications')->where('user_id', $user_id)->where('seen', 0);
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
                    'created'   => $row['created'],
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
}