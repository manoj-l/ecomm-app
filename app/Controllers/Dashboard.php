<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Customer;
use \App\Models\Order;
use \App\Models\OrderItem;
use DateTime;
use DatePeriod;
use DateInterval;

/**
 * Dashboard controller
 */
class Dashboard
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function index()
    {

        $customers = [];
        $orders = [];
        $revenueOre = 0;

        try {
            $customers = Customer::getAll();
            $orders = Order::getAll();
            $orderItems = OrderItem::getAll();

           
            $revenueOre = array_reduce($orderItems, function($total, $item) {
                $total += $item['price_total_ore'];
                return $total;
            });

            $fromDate = (array_key_exists('from-date', $_GET) && $this->validateDate($_GET['from-date'], 'Y-m-d') ) ? $_GET['from-date'] : date('Y-m-d', strtotime('-1 months'));
            $toDate = (array_key_exists('to-date', $_GET) && $this->validateDate($_GET['to-date'], 'Y-m-d') ) ? $_GET['to-date'] : date('Y-m-d');

            if ($fromDate > $toDate) {
                $fromDate = date('Y-m-d', strtotime('-1 months'));
                $toDate = date('Y-m-d');
            }
            $chartData = $this->getChartData( $fromDate,  $toDate,  $orders, $customers);
           
        }
        catch(Exception $e) {
            return back()->withInput()->withErrors(['message' => 'An unexpected error occurred. Please try again.']);
        }

        return View::renderTemplate('dashboard/index.twig', [
            'customersCount' => count($customers),
            'orderCount' => count($orders),
            'revenueSEK' => ($revenueOre/100),
            'chartData' => $chartData,
            'selectedDays' => [
                'fromDate' => $fromDate,
                'toDate' => $toDate,
            ]
        ]);
    }

    /**
     * To Validate a Date
     *
     * @return bool
     */
    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    /**
     * To get array of new customers and new orders to create a chart
     *
     * @return array
     */
    private function getChartData($fromDate, $toDate,  $orders, $customers)
    {
        $begin = new DateTime($fromDate);
        $end = new DateTime($toDate);


        $period = new DatePeriod(
            $begin,
            new DateInterval('P1D'),
            $end
        );

        $calendar = [];

        foreach ($period as $key => $value) {

            $filterDate = $value->format('Y-m-d');

            $newOrderCount = count(array_filter( $orders, function($item) use ($filterDate) {
                $utime = date('Y-m-d', strtotime($item['purchase_date']));
                return $utime === $filterDate;
            }));

            $newCustomerCount = count(array_filter( $customers, function($item) use ($filterDate) {
                $utime = date('Y-m-d', strtotime($item['created_at']));
                return $utime === $filterDate;
            }));

            $calendar[$filterDate] = [
                'date' => $value->format('Y M d'),
                'newOrderCount' => $newOrderCount,
                'newCustomerCount' => $newCustomerCount,
            ];
        }

        return $calendar;
    }
}
