<?php include "include/header.php"; ?>
<div class="main-content-inner-2" >
<div class="mt-5">
        <?php
        if(!empty($this->session->flashdata('hata'))){ 
            echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
        elseif(!empty($this->session->flashdata('onay'))){
            echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
    </div>
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Table Default</h4>
                    <div class="data-tables">
                        <table id="invoiceDataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>ID Number</th>
                                    <th>City</th>
                                    <th>Total Volume</th>
                                    <th>Total Commission</th>
                                    <th>Tax Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tradeTotalVeri">
                                <tr>
                                    <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                    <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                    <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                    <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                    <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                    <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                    <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                    <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<?php include "include/footer.php"; ?>