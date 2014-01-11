<?php



class OauthController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($provider)
	{

        // get data from input
        $code = Input::get( 'code' );
        // get google service
        $provider = ucfirst($provider);
        $googleService = OAuth::consumer($provider);

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

            $message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message. "<br/><pre>";

            //Var_dump
            //display whole array().
            dd($result);

        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to facebook login url
            return Redirect::away(urldecode($url));

        }
	}

    public function callback()
    {

        return 'CallBack';
    }


}