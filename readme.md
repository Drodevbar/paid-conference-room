### Tools:
* Laravel 5.7
* PHP 7.3

### Requirements:
* composer
* docker
* docker-compose
* your own ClickMeeting API key and PayPal client id, secret 

### Installation:
```bash
./initialize.sh
/* Fill out environmental variables (see Configuration section) */
docker-compose up
```

Visit localhost:8099

Note: Default application port is set to 8099. If you want to change it, see docker-compose.yml.

### Important project namespaces:
1. App\Http\Controllers
2. App\HttpClients
3. App\Services\ClickMeeting
4. App\Services\PayPal

### Configuration:
1. PayPal `client id` and `secret` are stored inside config/paypal.php file - you need to provide them
using environmental variables (`PAYPAL_CLIENT_ID`, `PAYPAL_SECRET`)
2. ClickMeeting `api key` is stored inside config/clickmeeting.php file - as previously you have to provide it (`CLICKMEETING_API_KEY`)
3. Some default conference details (including its price, room and user role) are stored inside config/conference.php file

### Simplified flow:
1. User sends the form data to the server
2. Server calls PayPal API to begin payment
3. Server calls ClickMeeting API to create new conference and autologin hash
4. Server redirects user to the conference

Note: This flow is really simplified - much more is happening out there, so it is desired to see the code in order to get it right.