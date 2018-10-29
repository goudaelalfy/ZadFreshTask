<p align="center"><img src="https://zadfresh.com/images/logo.png" width="200px"></p>

## About ZadFresh Task

Task to get Senior Laravel Developer vacancy in ZadFresh company, It is API for:

A student required to finish a book of thirteen chapters, he is allowed to choose when he starts, days he will be attending every week and a starting date.
You are required to develop a web service using Laravel framework that takes 3 inputs :
1- Starting date
2- int array with number of days per week assuming the start of the week is Saturday. 
Example: {2,4,6}
3- How many session required to finish one chapter.
Example: {6}
 
Response will be formatted using JSON returning array of dates representing the sessions schedule for this student till he finishes the 30 chapters :
Example: { Sessions:{"12/2/2015", "15/2/2015"} }


## Tools

Laravel v5.7, MySQL, Passport to authenticate APIs


## How to try?

- git clone the repository
- composer install
- create mysql database then update .inv file to set mysql data
- php artisan migrate
- php artisan passport:install //install passport for API authentication

- call POST API to resister new user to use APIs:
api/register

request (body) sample data:

{"name":"Gouda Elalfy","email":"goudaelalfy@hotmail.com","password":"123456","c_password":"123456"}



- call POST API to login by username and password
api/login 

request (body) sample data:

{"email":"goudaelalfy@hotmail.com","password":"123456"}



- call POST API:
api/student/getChaptersDates

request (header):		//For Authentication

'headers' => [
'Accept' => 'application/json',
'Authorization' => Bearer <access_token_returned_from_login_API_response>	// where access_token_returned_from_login_API_response is a response token by api/login API 
]

request (body) sample data:

{"starting_date":"2018-10-29","number_of_days_per_week_arr":[2, 4, 6],"session_numbers":"9"}



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
