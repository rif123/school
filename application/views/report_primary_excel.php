<?php
$time = date('Y-m-d H:i:s');
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=".$time.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table width="50%" >
    <thead>
        <tr>
            <td colspan="4" align="center" style="font-size:20px"><b>LAPORAN PEMBAYARAN PSB</b></td>
        </tr>
    </thead>
        <tr style="font-size:15px">
            <td><b>Payment</b></td>
            <td><b>Education</b></td>
            <td><b>QTY</b></td>
            <td><b>Total</b></td>
        </tr>

</table>

<table width="50%">
    <?php
        $qtyBayar = "";
        foreach ($listCountEducation as $k => $v) {
                echo "<tr>";
                    echo "<td>PSB</td>";
                    echo "<td>".$k."</td>";
                    echo "<td >".count($v)."</td>";
                    $total = 0;
                    foreach ($v as $ky => $vl) {
                        $total += $vl['price'];
                    }
                    echo "<td>".$total."</td>";
                echo "</tr>";
            $qtyBayar += $total;
        }
        echo "<tr>";
            echo "<td colspan='3' align='center'  style='font-size:15px'><b>Total</b></td>";
            echo "<td >".$qtyBayar."</td>";
        echo "</tr>"
    ?>
    <tbody>
        <?php
            $sumBayar = "";
            foreach ($listData as $key => $value) {
                echo "<tr>";
                    echo "<td>".$value['name']."</td>";
                    echo "<td>".$value['education_detail']."</td>";
                    echo "<td ></td>";
                    echo "<td>".$value['price']."</td>";
                echo "</tr>";
                $sumBayar += $value['price'];
            }
            echo "<tr>";
                echo "<td colspan='3' align='center' style='font-size:15px'><b>Total</b></td>";
                echo "<td>".$sumBayar."</td>";
            echo "</tr>";
        ?>
    </tbody>
</table>
