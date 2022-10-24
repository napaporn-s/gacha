<?php
    $products = [
        ["name" => "Small Potion Heal", "chance" => 0.12, "stock" => 1000],
        ["name" => "Medium Potion Heal", "chance" => 0.08, "stock" => 80],
        ["name" => "Big Potion Heal", "chance" => 0.06, "stock" => 15],
        ["name" => "Full Potion Heal", "chance" => 0.04, "stock" => 10],
        ["name" => "Small MP Potion", "chance" => 0.12, "stock" => 1000],
        ["name" => "Medium MP Potion", "chance" => 0.08, "stock" => 80],
        ["name" => "Big MP Potion", "chance" => 0.06, "stock" => 15],
        ["name" => "Full MP Potion", "chance" => 0.04, "stock" => 8],
        ["name" => "Attack Ring", "chance" => 0.05, "stock" => 10],
        ["name" => "Defense Ring", "chance" => 0.05, "stock" => 10],
        ["name" => "Lucky Key", "chance" => 0.15, "stock" => 1000],
        ["name" => "Silver Key", "chance" => 0.15, "stock" => 1000]
    ];

    $counts = array();
    foreach ($products as $product) {
        $counts[$product["name"]] = 0;
    }

    $stocks = array();
    foreach ($products as $product) {
        $stocks[$product["name"]] = $product["stock"];
    }

    function getRandomElement(array $products) {
        
        $productName = array();
        $productChance = array();

        foreach ($products as $product) {
            $productName[] = $product["name"];
            $productChance[] = $product["chance"];
        }

        $randoms = array_combine($productName, $productChance);

        $chanceRandom = 0;
        foreach ($randoms as $key => $value){
            $chanceRandom += (int) ($value*100);
        }

        $rand = mt_rand(1, $chanceRandom);
        $range = 0;
        
        foreach ($randoms as $key => $value) {
            $range += (int) ($value*100);
            $compare = $rand - $range;
            if ($compare <= 0){
                return (string) $key;
            }
        }

        shuffle($randoms);
    }

    function getLastCountElement(array $counts, $product) {
        foreach ($counts as $key => $value) {
            if ($key == $product) {
                return $value;
            }
        }
    }

    function getLastStockElement(array $stocks, $product) {
        foreach ($stocks as $key => $value) {
            if ($key == $product) {
                return $value;
            }
        }
    }

    $randoms = array();

    for ($i = 0; $i < 100;) {
        $product = getRandomElement($products);
        $randcount = getLastCountElement($counts, $product);
        $randstock = getLastStockElement($stocks, $product);
        if ($randcount >= $randstock) {

        } else {
            $randoms[] = $product;
            $randcount = getLastCountElement($counts, $product);
            $counts[$product] = $randcount + 1;
            $i++;
        }
    }

    $j = 1;
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<table border=\"1\">";
    echo "<tr style=\"background-color:green;\"> <td width=\"100\">No.</td> <td width=\"200px\">Result</td> </tr>";
    foreach ($randoms as $key => $value) {
        echo "<tr>";
        echo "<td>".$j++."</td>";
        echo "<td width=\"200\">".$value."</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</td>";
    echo "<td valign=\"top\">";
    echo "<table border=\"1\">";
    echo "<tr style=\"background-color:yellow;\"> <td width=\"200\">Name</td> <td width=\"200px\">Stock</td>  <td width=\"200px\">Count</td> </tr>";
    foreach ($counts as $key => $value) {
        echo "<tr>";
        echo "<td width=\"200\">".$key."</td>";
        echo "<td width=\"200\">".getLastStockElement($stocks, $key)."</td>";
        echo "<td width=\"200\">".$value."</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
?>