<?php

namespace App\Http\Controllers;

use App\View;
use DB;
use App\Models\Currency;
use App\Models\Exchange;

use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

   
    public function updateExchange(){

        $api_key = 'UCCHWATS1JVXNFR4';

        $Exchange = Exchange::where('date', date('y-m-d'))->get();

        if($Exchange->Count() == 0){            

            $combinations = [];
            $currencies = Currency::all();        
            $index  = 0;

            foreach($currencies as $currency){
                
                for($x = $index + 1; $x <= $currencies->count()-1; $x++){

                    $destinyCurrency = $currencies[$x];

                    $combinations[] = ["Origin" => $currency->Symbol,
                                        "OriginId" => $currency->id, 
                                        "Destiny" => $destinyCurrency->Symbol,
                                        "DestinyId" => $destinyCurrency->id
                                    ];
                }
                $index ++;
            }


            foreach($combinations as $combination){
                $origin = $combination['Origin'];
                $originId = $combination["OriginId"];
                $destiny = $combination['Destiny'];
                $destinyId = $combination["DestinyId"];

                $url = "https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency=" . $origin . "&to_currency=" . $destiny . "&apikey=" . $api_key;
                $json = file_get_contents($url);
                $json = json_decode(file_get_contents($url), true);
            

                // if($origin == "USD" && $destiny == "EUR")
                //     dd($url);

                $exchange = ($json["Realtime Currency Exchange Rate"]["5. Exchange Rate"]);

                $Exchange = new Exchange();
                $Exchange->date = date('y-m-d');
                $Exchange->currencyIdOrigin = $originId;
                $Exchange->currencyIdDestiny = $destinyId;
                $Exchange->price = $exchange;
                $Exchange->save();

                $Exchange = new Exchange();
                $Exchange->date = date('y-m-d');
                $Exchange->currencyIdOrigin = $destinyId;
                $Exchange->currencyIdDestiny = $originId;
                $Exchange->price = 1 / $exchange;
                $Exchange->save();

                sleep(5);
            }
        
            

        }

        return "Proceso terminado correctamente";
    }

  
}