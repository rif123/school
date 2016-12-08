<html>
    <?php include 'view_head.php'; ?>  
    <style type="text/css">
        @page { margin: 0; }

        .nopadding {
           padding: 0 !important;
           margin: 0 !important;
        }
        .left-style img{
            padding-top:10px;
        }
        @media print {
            div.image-data{
                -webkit-print-color-adjust: exact; 
            }
        }
        @media print {
            .image-data th {
                color: white !important;
            }
        }
        
    </style>
    <!--
    <body>
    -->
    <body onload="window.print();">
        <div class="wrapper">
            <!-- Main content -->
            <?php for($i=0;$i<3;$i++){?>
            <section class="invoice" style="padding:12px;">
                <!-- title row -->
                <div class="row" style="margin-bottom: 8px;">
                    <div class="col-xs-12">
                    </div><!-- /.col -->
                </div>
                <!-- info row -->               
                    
                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-3" >
                        <img src="<?php echo base_url(); ?>assets/dist/img/logo kwitansi.jpg" class="image-data" style="height: 315px;"></img>
                    </div>
                    <div class="col-xs-9 table-responsive">
                        <div class="table-responsive">
                            <table class="tablebaru" style="font-size: 14px; margin-bottom:0px; width:100%" colspadding="10px">
                                <tr>
                                    <th style="width:30%">No.</th>
                                    <td><?php echo $payment_id;?></td>
                                </tr>
                                <tr>
                                    <th>Sudah diterima dari</th>
                                    <td><?php echo $name;?></td>
                                </tr>                                
                                <tr>
                                    <th>Uang sebanyak</th>
                                    <td class="payment_total"><?php echo $payment_total;?></td>
                                </tr>
                                <tr>
                                    <th>Guna membayar</th>
                                    <td><?php echo $payment_type_detail;?></td>
                                </tr>
                                <tr>
                                    <th>Terbilang</th>
                                    <td class="said"><?php echo $payment_total;?></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-6" style="font-size: 11px;">
                        <i>
                            Catatan:
                            <ul>
                                <li>Pembayaran berikutnya kwitansi ini harus dibawa</li>
                                <li>Uang yang sudah masuk tidak bisa dikembalikan.</li>
                            </ul>
                                
                        </i>
                    </div>
                    <div class="col-xs-3" style="font-size: 11px; padding-right:30px;">
                        <div class="row" style="border-bottom: 1px solid #f3f3f3">
                            <?php echo $payment_date_extracted;?>
                        </div>
                        <div class="row" style="margin-top:13px; margin-bottom: 38px; text-align: center">
                            Penerima,
                        </div>
                        <div class="row" style="border-bottom: 1px solid #f3f3f3; text-align: center">
                            <?php 
                            echo $this->session->userdata('staff')->name;
                            ?>
                            
                        </div>
                            
                    </div>
                </div><!-- /.row -->            
            </section><!-- /.content -->   
            <?php } ?>
        </div><!-- ./wrapper -->
            
        <!-- AdminLTE App -->
        <!--script src="../../dist/js/app.min.js"></script-->
       <?php include 'view_footer.php'; ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/native.js"></script>
    </body>
</html>
<style>
.tablebaru > thead > tr > th, .tablebaru > tbody > tr > th, .tablebaru > tfoot > tr > th, .tablebaru > thead > tr > td, .tablebaru > tbody > tr > td, .tablebaru > tfoot > tr > td {
    border-top: 1px solid #f4f4f4;
    padding:10px;
}
</style>