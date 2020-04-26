<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PortfolioController extends Controller
{
    public function index() {
        $total_price =0;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency=".Config::get('vars.currency')."&order=market_cap_desc&per_page=50&page=1&sparkline=false",
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
        $found_currencies = [];
        $missing_currencies= [];
        foreach ($response as $resp_currency) {
            foreach ($portfolio_entries as $entry) {
                if ($resp_currency->id === $entry->name) {
                    $resp_currency->amount = $entry->amount;
                    $found_currencies[] = $entry->name;
                    break;
                }
            }
        }
        foreach ($portfolio_entries as $entry) {
            if (!in_array($entry->name,$found_currencies) && !in_array($entry->name,$missing_currencies)) {
                $missing_currencies[] = $entry->name;
            }
        }
        $missing_currencies = self::requestMissingCurrencies($missing_currencies);

        foreach ($missing_currencies as $missing) {
            foreach ($portfolio_entries as $entry) {
                if($missing->id === $entry->name) {
                    $missing->amount = $entry->amount;
                }
            }
        }

        $all_currencies = array_merge($response,$missing_currencies);



        return view('portfolio',[
            'portfolio_entries' => $portfolio_entries,
            'response'          => $response,
            'currencies'        => $all_currencies
        ]);
    }


    public function nextCurrencies($page_number) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency=".Config::get('vars.currency')."&order=market_cap_desc&per_page=50&page=".$page_number."&sparkline=false",
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

        return view('partials/portfolio_currencies',[
            'currencies'          => $response
        ]);
    }


    function requestMissingCurrencies($currencies_list) {

        $missing_currencies_string = implode("%2C",$currencies_list);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency=".Config::get('vars.currency')."&ids=" . $missing_currencies_string . "&order=market_cap_desc&per_page=100&page=1&sparkline=false",
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
        return json_decode($response);
    }

    public function insert(Request $request) {
        $currency = new Portfolio();

        $name = $request->input('name');
        $amount = $request->input('amount');

        if ( $amount > 0) {
            $currency = \App\Portfolio::updateOrCreate(
                ['name' => $name],
                ['amount' => $amount]
            );
        } else {
            self::deleteCurrency($name);
        }


    }
    public function refreshCurrency($name) {

        $amount = \App\Portfolio::where('name', $name)->get();
        if (count($amount) === 0) {
            $amount = 0;
        }
        return $amount;
    }

    public function deleteCurrency($name) {
        $currency =  \App\Portfolio::where('name',$name);
        $currency->delete();
    }
}
