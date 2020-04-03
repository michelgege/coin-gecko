<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index() {
        $total_price =0;
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency=eur&order=market_cap_desc&per_page=50&page=1&sparkline=false",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_COOKIE => "__cfduid=d216f9d6aabfbbd232452f0c8c2fc96891582274696",

        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        }

        $response = json_decode($response);
        $portfolio_entries = json_decode(\App\Portfolio::all());

        foreach($response as $currency) {

            foreach ($portfolio_entries as $entry) {

                if($entry->name == $currency->id) {

                    $total_price = $total_price + ($currency->current_price * $entry->amount);
                    break;
                }
            }
        }

        return view('portfolio',['portfolio_entries' => $portfolio_entries,'response' => $response,'total_price' => $total_price]);
    }



    public function insert(Request $request) {


        $currency = new Portfolio();
        $currency = \App\Portfolio::updateOrCreate(

            ['name' => $request->input('name')],
            ['amount' => $request->input('amount')]
        );

        return self::index();
    }
}
