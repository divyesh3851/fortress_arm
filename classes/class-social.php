<?php

/**
 * Class For Settings Login And Manage All Modual
 */

class Social
{

    protected static $instance;

    public function __construct()
    {
    }

    function get_youtube_data()
    {

        $apiKey = get_option('youtube_api_key'); // Replace with your YouTube API key
        $channelId = get_option('youtube_channel_id'); // Replace with the YouTube channel ID

        // YouTube Data API endpoint to get channel statistics
        $url = "https://www.googleapis.com/youtube/v3/channels?part=statistics&id={$channelId}&key={$apiKey}";

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);
        if (isset($data['items'][0])) {
            //$subscriberCount = $data['items'][0]['statistics']['subscriberCount'];
            return $data;
        } else {
            return false;
        }

        return false;
    }

    function get_linkdin_data()
    {
        $clientId = get_option('linkdin_client_id');
        $clientSecret = get_option('linkdin_client_secret');
        $redirectUri = site_url() . '/admin'; // Replace with your actual redirect URI
        $organizationId = get_option('linkdin_organization_id');

        // Step 1: Get Authorization Code (manual process, use LinkedIn's OAuth dialog)

        // Step 2: Exchange Authorization Code for Access Token
        $authorizationCode = get_option('authorization_code'); // Retrieved from OAuth flow

        $tokenUrl = "https://www.linkedin.com/oauth/v2/accessToken";
        $postFields = [
            'grant_type' => 'authorization_code',
            'code' => $authorizationCode,
            'redirect_uri' => $redirectUri,
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        if (isset($responseData['access_token'])) {
            $accessToken = $responseData['access_token'];

            // Step 3: Use Access Token to Fetch Follower Count
            $url = "https://api.linkedin.com/v2/organizationalEntityFollowerStatistics?q=organizationalEntity&organizationalEntity=urn:li:organization:{$organizationId}";

            $headers = [
                "Authorization: Bearer {$accessToken}",
                "Content-Type: application/json",
                "x-li-format: json"
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);
            if (isset($data['elements'][0])) {
                //$followerCount = $data['elements'][0]['followerCounts']['organicFollowerCount'];
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
        return false;
    }

    function get_fb_follower_count()
    {

        $page_id = get_option('fb_page_id');

        $access_token = get_option('fb_page_access_token');

        // Facebook Graph API endpoint
        $url = "https://graph.facebook.com/{$page_id}?fields=followers_count&access_token={$access_token}";

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);
        if (isset($data)) {
            return $data;
        }

        return false;
        die();
    }

    function get_insta_access_token()
    {
        $app_id = get_option('instagram_app_id');

        $scope = 'user_profile,user_media';

        $responseType = 'code';

        $redirectUri = site_url() . '/get_insta_analytics.php'; // Replace with your actual redirect URI 

        $authUrl = "https://api.instagram.com/oauth/authorize?client_id={$app_id}&redirect_uri={$redirectUri}&scope={$scope}&response_type={$responseType}";

        wp_redirect($authUrl);
        exit;
    }

    function get_insta_anaylitics_data()
    {
        $user_id = get_option('instagram_user_id'); // insta user id

        $access_token = get_option('instagram_access_token');

        // Instagram Graph API endpoint
        $url = "https://graph.instagram.com/{$user_id}?fields=id,username,followers_count&access_token={$access_token}";

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);
        if (isset($data)) {
            return $data;
        } else {
            return false;
        }

        die();
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

function Social()
{
    return Social::get_instance();
}

Social();
