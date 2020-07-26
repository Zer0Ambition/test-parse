<?php 

namespace common\models;

use Yii;
use yii\base\Model;

class TableParser extends Model
{
    public function parseHTMLTable($table) {
        //Load HTML file
        $data = file_get_contents($table);
        $dom = new \domDocument;
        $dom->loadHTML($data);
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');

        $rows = $tables->item(0)->getElementsByTagName('tr');

        //Find a "Profit", "Open Time" and "Type" columns` indexes
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            $i = 0;
            foreach($cols as $col) {
                if ($col->textContent == "Profit") {
                    $indexProfit = $i;
                }

                if ($col->textContent == "Open Time") {
                    $indexDate = $i;
                }

                if ($col->textContent == "Type") {
                    $indexType = $i;
                }
                $i++;
            }
        }

        $i = 0;
        $balance = 0;
        $result = [];
        //Get text from columns
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            if ($cols->item($indexType)->textContent == "balance" || $cols->item($indexType)->textContent == "buy") {
                if ($cols->item($indexType)->textContent == "buy") {
                    $balance += filter_var(str_replace(' ', '', $cols->item($indexProfit)->textContent), FILTER_VALIDATE_FLOAT);
                }
                else {
                    $balance += filter_var(str_replace(' ', '', $cols->item(4)->textContent), FILTER_VALIDATE_FLOAT);
                }
                $result[$i]['balance'] = $balance;
                $result[$i]['date'] = $cols->item($indexDate)->textContent;
                $i++;
            }        
        }

        return $result;
    }
}