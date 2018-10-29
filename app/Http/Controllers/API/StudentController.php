<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class StudentController extends Controller {

    public $successStatus = 200;

    /**
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getChaptersDates(Request $request) {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
                    'starting_date' => 'required|date_format:Y-m-d',
                    'number_of_days_per_week_arr' => 'required|array',
                    'session_numbers' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $days_per_week_arr = array(1 => 'saturday', 2 => 'sunday', 3 => 'monday', 4 => 'tuesday', 5 => 'wednesday', 6 => 'thursday', 7 => 'friday');
        $days_index_per_week_arr = array(1 => 6, 2 => 0, 3 => 1, 4 => 2, 5 => 3, 6 => 4, 7 => 5);

        //This array to between php week days array and our array, you told me in email our week start on saturday.
        $days_index_per_week_map_php_to_our_arr = array(0 => 2, 1 => 3, 2 => 4, 3 => 5, 4 => 6, 5 => 7, 6 => 1);


        $input = $request->all();

        $starting_date = $input['starting_date'];

        $dayofweek_starting_date = date('w', strtotime($starting_date)); //1
        $our_dayofweek_starting_date = $days_index_per_week_map_php_to_our_arr[$dayofweek_starting_date]; // 3

        $number_of_days_per_week_arr = $input['number_of_days_per_week_arr'];
        $number_of_days_per_week_arr_count = count($number_of_days_per_week_arr);

        $session_numbers = $input['session_numbers'];


        $couner_dates = 1;
        for ($i = 1; $i <= ($session_numbers / $number_of_days_per_week_arr_count) + 1; $i++) {
            foreach ($number_of_days_per_week_arr as $number_of_days_per_week) {

                if ($couner_dates <= $session_numbers) {
                    if ($number_of_days_per_week >= $our_dayofweek_starting_date) {
                        $chapters_dates_arr['session ' . $couner_dates] = date('Y-m-d', strtotime($starting_date . ' + ' . ( (($i - 1) * 7) + ($number_of_days_per_week - $our_dayofweek_starting_date)) . ' days'));

                        $couner_dates++;
                    } else {
                        if ($couner_dates > 1) {
                            $chapters_dates_arr['session ' . $couner_dates] = date('Y-m-d', strtotime($starting_date . ' + ' . ((($i - 1) * 7) - ($our_dayofweek_starting_date - $number_of_days_per_week) ) . ' days'));

                            $couner_dates++;
                        }
                    }
                }
            }
        }
        $sessions = $chapters_dates_arr;

        return response()->json(['sessions' => $chapters_dates_arr]);
    }

}
