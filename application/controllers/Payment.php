<?php
class Payment extends CI_Controller{
    private $bankcharges = 3500;
    private $feecode = "SF";
    private $purpose = "KGSCNMO School Fees - ";
    private $paytbl = "remita_payment_sf";
    private $startsess = "2019/2020";
    //accommodation
    private $hcapacity = 532;
    private $hpaytbl = "remita_payment_ac";
    private $hamt = 30000;
    private $hbankcharges = 500;
    private $hfeecode = "AF";
    private $hpurpose = "KGSCNMO Accommodation Fee - ";
    //
    function __construct(){
        parent::__construct();
        $this->load->model('crud_model');
        $this->loggedin();
    }
    //
    private function loggedin(){
        if(!$this->session->userdata('sloggedin')){
            redirect('index');
        }
    }
    //
    function index(){
        $data['page'] = "payment";
        $data['hcapacity'] = $this->hcapacity;
        //get user parameters
        $appno = $this->session->userdata('appno');
        $where = array('appno'=>$appno);
        $data['userdet'] = $udet = $this->crud_model->get_where('student', $where);
        $udet = $udet->row_array();
        $admsess = $udet['admsess'];
        $indigene = $udet['indigene'];
        $name = $udet['firstname']." ".$udet['middlename']." ".$udet['lastname'];
        $phone = $udet['phone'];
        $email = $udet['email'];
        $data['cat'] = $cat = studentCat($admsess);
        $data['activesess'] = activeSess($cat);
        //get sessions
        $data['allsess']  = $this->crud_model->custom("select distinct sess from session where sess>='$admsess' order by sess DESC")->result_array();
        /*if ($this->input->post('sbtn')){
            $data['selsess'] = $sess = $this->input->post('sess');
            //fetch school fees payment details
            $paydet = $this->fetchPayDet($appno, $sess);
            $rrr = ($paydet) ? $paydet['rrr'] : "";
            $orderid = ($paydet) ? $paydet['orderid'] : "";
            $status = ($paydet) ? $paydet['status'] : "";
            $amt = ($paydet) ? $paydet['amount'] : "";
            $transdate = ($paydet) ? $paydet['transdate'] : "";
            if($rrr){
                if($status=="paid"){
                    $resp = array('rrr'=>$rrr, 'orderid'=>$orderid, 'status'=>$status, 'error'=>FALSE, 'amount'=>$amt, 'transdate'=>$transdate);
                }
                else{
                    $statusdet = $this->status($rrr);
                    $respcode = $statusdet['status'];
                    //$resprrr = $statusdet['RRR'];
                    $resprrr = (isset($statusdet['RRR'])) ? $statusdet['RRR'] : $rrr;
                    $respmsg = $statusdet['message'];
                    if($respcode=="01" || $respcode=="00"){
                        $now = time();
                        $transdate = (isset($statusdet['paymentDate']) && $statusdet['paymentDate']) ? strtotime($statusdet['paymentDate']) : $now;
                        $wh = array('rrr'=>$resprrr);
                        $dt = array('status'=>'paid', 'transdate'=>$transdate);
                        $this->crud_model->update($this->paytbl, $dt, $wh);
                        $resp = array('rrr'=>$resprrr, 'orderid'=>$orderid, 'status'=>'paid', 'error'=>FALSE, 'amount'=>$amt, 'transdate'=>$transdate);
                    }
                    else{
                        if(strtolower($respmsg)=="rejected" || strtolower($respmsg)=="invalid rrr"){
                            //nullify existing record
                            $dt3 = array('matno'=>$appno.'_');
                            $wh3 = array('matno'=>$appno, 'sess'=>$sess);
                            $this->crud_model->update($this->paytbl, $dt3, $wh3);
                            redirect('payment');
                        }
                        else{
                            $resp = array('rrr'=>$resprrr, 'orderid'=>$orderid, 'status'=>'', 'error'=>$respmsg, 'amount'=>$amt, 'transdate'=>$transdate);
                        }
                    }
                }
            }
            else{
                //delete existing record
                $wh2 = array('matno'=>$appno, 'sess'=>$sess);
                $this->crud_model->delete($this->paytbl, $wh2);
                //generate RRR
                $amt = $this->invAmt($indigene, $admsess, $sess, $appno);
                if($amt){
                    $amt+=$this->bankcharges;
                    $orderid = $this->feecode.$appno.DATE("dmyHis");
                    $purpose = $this->purpose.$sess;
                    $resp = $this->generateRRR($amt, $name, $email, $phone, $orderid, $purpose);
                    if(isset($resp['rrr']) && $resp['rrr']) {
                        $dt = array('matno' => $appno, 'orderid' => $resp['orderid'], 'sess' => $sess, 'name' => $name, 'phone' => $phone, 'email' => $email, 'amount' => $resp['amount'], 'rrr' => $resp['rrr'], 'purpose' => $purpose);
                        $this->crud_model->add($this->paytbl, $dt);
                    }
                    else{
                        $resp = array('rrr'=>FALSE, 'orderid'=>FALSE, 'status'=>'', 'error'=>'Error generating RRR. Please try again later', 'amount'=>$amt, 'transdate'=>$transdate);
                    }
                }
                else{
                    $resp = array('rrr'=>FALSE, 'orderid'=>FALSE, 'status'=>'', 'error'=>'Invalid invoice amount', 'amount'=>$amt, 'transdate'=>$transdate);
                }
            }
            $data['resp'] = $resp;
            //check defaulting
            $prevsess = $this->prevSess($sess);
            if($prevsess<$this->startsess){
                $data['defaulting'] = FALSE;
            }
            else{
                $ppaid = $this->paid($appno, $prevsess);
                if($admsess>$sess){
                    $data['defaulting'] = FALSE;
                }
                elseif($resp['status']!="paid" && $admsess!=$sess && !$ppaid){
                    $data['defaulting'] = TRUE;
                }
                else{
                    $data['defaulting'] = FALSE;
                }
            }
        }*/
        //
        $this->load->view('payment_view', $data);
    }
    //
    function load(){
        $appno = $this->session->userdata('appno');
        $cat = ($this->input->post('cat')) ? $this->input->post('cat') : "";
        $studentDet = rowDet('student', array('appno'=>$appno));
        $studentName = $studentDet['firstname']." ".$studentDet['middlename']." ".$studentDet['lastname'];
        $admSess = $studentDet['admsess'];
        $phone = $studentDet['phone'];
        $email = $studentDet['email'];
        //load payment
        if ($cat == "LoadPayment") {
            $sess = $this->input->post('sess');
            //fetch school fees payment details
            $paydet = rowDet($this->paytbl, array('matno'=>$appno, 'sess'=>$sess));
            $rrr = ($paydet) ? $paydet['rrr'] : "";
            $orderid = ($paydet) ? $paydet['orderid'] : "";
            $status = ($paydet) ? $paydet['status'] : "";
            $amt = ($paydet) ? $paydet['amount'] : "";
            $transdate = ($paydet) ? $paydet['transdate'] : "";
            if($rrr){
                if($status=="paid"){
                    $resp = array('rrr'=>$rrr, 'orderid'=>$orderid, 'status'=>$status, 'error'=>FALSE, 'amount'=>$amt, 'transdate'=>$transdate);
                }
                else{
                    $statusdet = $this->status($rrr);
                    $respcode = $statusdet['status'];
                    $resprrr = (isset($statusdet['RRR'])) ? $statusdet['RRR'] : $rrr;
                    $respmsg = $statusdet['message'];
                    if($respcode=="01" || $respcode=="00"){
                        $now = time();
                        $transdate = (isset($statusdet['paymentDate']) && $statusdet['paymentDate']) ? strtotime($statusdet['paymentDate']) : $now;
                        $wh = array('rrr'=>$resprrr);
                        $dt = array('status'=>'paid', 'transdate'=>$transdate);
                        $this->crud_model->update($this->paytbl, $dt, $wh);
                        $resp = array('rrr'=>$resprrr, 'orderid'=>$orderid, 'status'=>'paid', 'error'=>FALSE, 'amount'=>$amt, 'transdate'=>$transdate);
                    }
                    else{
                        if(strtolower($respmsg)=="rejected" || strtolower($respmsg)=="invalid rrr" || $amt != ($this->invAmt($studentDet['indigene'], $admSess, $sess, $appno) + $this->bankcharges)){
                            //nullify existing record
                            $dt3 = array('matno'=>$appno.'_');
                            $wh3 = array('matno'=>$appno, 'sess'=>$sess);
                            $this->crud_model->update($this->paytbl, $dt3, $wh3);
                            $resp = array('rrr'=>'', 'orderid'=>'', 'status'=>'', 'error'=>'Change in amount. Please reload', 'amount'=>0, 'transdate'=>'');
                            pageRedirect('payment');
                        }
                        else{
                            $resp = array('rrr'=>$resprrr, 'orderid'=>$orderid, 'status'=>'', 'error'=>$respmsg, 'amount'=>$amt, 'transdate'=>$transdate);
                        }
                    }
                }
            }
            else{
                //delete existing record
                $wh2 = array('matno'=>$appno, 'sess'=>$sess);
                $this->crud_model->delete($this->paytbl, $wh2);
                //generate RRR
                $amt = $this->invAmt($studentDet['indigene'], $admSess, $sess, $appno);
                if($amt){
                    $amt+=$this->bankcharges;
                    $orderid = $this->feecode.$appno.DATE("dmyHis");
                    $purpose = $this->purpose.$sess;
                    $resp = $this->generateRRR($amt, $studentName, $email, $phone, $orderid, $this->purpose);
                    if(isset($resp['rrr']) && $resp['rrr']) {
                        $dt = array('matno' => $appno, 'orderid' => $resp['orderid'], 'sess' => $sess, 'name' => $studentName, 'phone' => $phone, 'email' => $email, 'amount' => $resp['amount'], 'rrr' => $resp['rrr'], 'purpose' => $purpose);
                        $this->crud_model->add($this->paytbl, $dt);
                    }
                    else{
                        $resp = array('rrr'=>FALSE, 'orderid'=>FALSE, 'status'=>'', 'error'=>'Error generating RRR. Please try again later', 'amount'=>$amt, 'transdate'=>$transdate);
                        //print $resp; exit();
                    }
                }
                else{
                    $resp = array('rrr'=>FALSE, 'orderid'=>FALSE, 'status'=>'', 'error'=>'Invalid invoice amount', 'amount'=>$amt, 'transdate'=>$transdate);
                }
            }
            //check defaulting
            $prevsess = $this->prevSess($sess);
            if($prevsess<$this->startsess){
                $defaulting = FALSE;
            }
            else{
                $ppaid = $this->paid($appno, $prevsess);
                if($admSess > $sess){
                    $defaulting = FALSE;
                }
                elseif($resp['status']!="paid" && $admSess!=$sess && !$ppaid){
                    $defaulting = TRUE;
                }
                else{
                    $defaulting = FALSE;
                }
            }
            //print_r($resp);
            //display
            $rrr = $resp['rrr'];
            $orderid = $resp['orderid'];
            $status = $resp['status'];
            $error = $resp['error'];
            $amount = $resp['amount'];
            $transdate = $resp['transdate'];
            if($defaulting){
                normAlert('EYou have not paid your fees for the previous academic session');
            }
            else{
                if($status=="paid"){
                    normAlert('SYour payment has been confirmed successfully.<p><strong>Order ID:</strong> '.$orderid.'</p><p><strong>RRR:</strong> '.$rrr.'</p><p><strong>Amount:</strong> '.number_format($amount, 2).'</p><p><strong>Transaction Date:</strong> '.date("D M j, Y g:i a", $transdate).'</p>');
                    normAlert("I<strong>NOTE:</strong> Student Union and NAKOSS fee should be paid into the following account details:<br>
                    <strong>Account Number:</strong> <br>
                    Student Union: 2183336628<br>
                    NAKOSS:2254152082<br>
                    <strong>Bank:</strong> UBA");
                    ?>
                    <form action="<?= base_url('receipt/index'); ?>" method="post" target="_blank">
                        <input type="hidden" name="sess" value="<?= $sess; ?>">
                        <button type="submit" name="sbtn" value="sbtn" class="btn btn-block btn-success">Print School Fees Receipt [<?= $sess; ?>]</button>
                    </form>
                    <?php
                }
                else{
                    //normAlert("W<strong>NOTE:</strong> Fees will be increased from 1st June 2023</strong>");
                    if($error){ normAlert('E'.$error); }
                    if ($amount){
                        ?>
                        <h6><strong>Payment Details</strong></h6>
                        <p>Order ID: <?= $orderid; ?></p>
                        <p style="font-weight: bold;">RRR: <?= $rrr; ?></p>
                        <p>Amount: <?= number_format($amount, 2); ?></p>
                        <form onsubmit="makePayment()" id="payment-form">
                            <input type="hidden" id="transactionId" value="<?= $orderid; ?>">
                            <input type="hidden" id="js-rrr" name="rrr" value="<?= $rrr; ?>">
                            <button class="btn btn-lg btn-block btn-success" onclick="makePayment()"><i class="fa fa-check"></i>&nbsp; Pay Now (<?= number_format($amount, 2); ?>)</button>
                        </form>
                        <?php
                    }
                    ?>
                    <a href="http://www.remita.net" target="_blank"><img height="80px" src="<?php print base_url('assets/images/remita.png'); ?>"> </a>
                    <?php
                }
            }
        }
    }
    //
    private function prevSess($sess){
        $s1 = $sess[0].$sess[1].$sess[2].$sess[3];
        $s2 = $sess[5].$sess[6].$sess[7].$sess[8];
        return (intval($s1)-1)."/".(intval($s2)-1);
    }
    //
    private function paid($appno, $sess){
        $where = array('matno'=>$appno, 'sess'=>$sess, 'status'=>'paid');
        $data = $this->crud_model->get_where($this->paytbl, $where);
        $ret = ($data->num_rows()>0) ? TRUE : FALSE;
        return $ret;
    }
    //
    private function invAmt($indigene, $admsess, $sess, $appno){
        //restrict set 51 from fee increase in 2025/2026 session, by maintaining fee for 2024/2025
        if ($appno[0].$appno[1] == "51" && $sess>="2025/2026"){
            $sess = "2024/2025";
        }
        //
        $cat = ($admsess>=$sess) ? "fresh" : "returning";
        $where = array('sess'=>$sess, 'indigene'=>$indigene, 'cat'=>$cat);
        $data = $this->crud_model->get_where('schedule', $where);
        $data = $data->row_array();
        return $data['total'];
    }
    //school fees
    private function generateRRR($totalAmount, $payerName, $payerEmail, $payerPhone, $orderID, $purpose){
        $timesammp=DATE("dmyHis");
        $gatewayUrl = GATEWAYURL;
        $merchantId = MERCHANTID;
        $serviceTypeID = SERVICETYPEID;
        $responseurl = PATH;
        $hash_string = MERCHANTID . SERVICETYPEID . $orderID . $totalAmount . APIKEY;
        $hash = hash('sha512', $hash_string);
        $itemtimestamp = $timesammp;
        $itemid1="acct1";
        $itemid2="acct2";
        $itemid3="acct3";
        $beneficiaryName="KOGI STATE COLLEGE OF NURSING AND MIDWIFERY, OBANGEDE";
        $beneficiaryName2="BLESSEMOL CONSULT";
        $beneficiaryName3="DATA CENTRE AND ASSOCIATES LTD";
        $beneficiaryAccount="0028908304";
        $beneficiaryAccount2="1015685356";
        $beneficiaryAccount3="1018058661";
        $bankCode="215";
        $bankCode2="057";
        $bankCode3="033";
        $beneficiaryAmount = ($totalAmount-3500);
        $beneficiaryAmount2 = "2500";
        $beneficiaryAmount3 = "1000";
        $deductFeeFrom = 0;
        $deductFeeFrom2 = 1;
        $deductFeeFrom3 = 0;

        $content = "{\"serviceTypeId\": \"$serviceTypeID\",
		\"amount\": \"$totalAmount\",
		\"orderId\": \"$orderID\",
		\"payerName\": \"$payerName\",
		\"payerEmail\": \"$payerEmail\",
		\"payerPhone\": \"$payerPhone\",
		\"description\": \"$purpose\",
		\"lineItems\":[
			{\"lineItemsId\":\"$itemid1\",\"beneficiaryName\":\"$beneficiaryName\", \"beneficiaryAccount\":\"$beneficiaryAccount\",\"bankCode\":\"$bankCode\",\"beneficiaryAmount\":\"$beneficiaryAmount\",\"deductFeeFrom\":\"$deductFeeFrom\"},
			
			{\"lineItemsId\":\"$itemid2\",\"beneficiaryName\":\"$beneficiaryName2\", \"beneficiaryAccount\":\"$beneficiaryAccount2\",\"bankCode\":\"$bankCode2\",\"beneficiaryAmount\":\"$beneficiaryAmount2\",\"deductFeeFrom\":\"$deductFeeFrom2\"},

{\"lineItemsId\":\"$itemid3\",\"beneficiaryName\":\"$beneficiaryName3\",\"beneficiaryAccount\":\"$beneficiaryAccount3\",\"bankCode\":\"$bankCode3\",\"beneficiaryAmount\":\"$beneficiaryAmount3\",\"deductFeeFrom\":\"$deductFeeFrom3\"}]}";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $gatewayUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $content,
            CURLOPT_HTTPHEADER => array(
                "Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $json_response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $jsonData = substr($json_response, 7, -1);
        $response = json_decode($jsonData, true);

        $statuscode = $response['statuscode'];
        //return $json_response;
        $statusMsg = $response['status'];
        if($statuscode=='025'){
            $ret['rrr'] = trim($response['RRR']);
            $ret['orderid'] = $orderID;
            $ret['status'] = '';
            $ret['error'] = FALSE;
            $ret['amount'] = $totalAmount;
            $ret['transdate'] = '';
        }
        else{
            $ret['rrr'] = FALSE;
            $ret['orderid'] = FALSE;
            $ret['status'] = '';
            $ret['error'] = "Error Generating RRR - ".$statusMsg;
            $ret['amount'] = $totalAmount;
            $ret['transdate'] = '';
        }
        return $ret;
        //return $json_response;
    }
    //accommodation fee
    private function generateHostelRRR($totalAmount, $payerName, $payerEmail, $payerPhone, $orderID, $purpose){
        $timesammp=DATE("dmyHis");
        $gatewayUrl = GATEWAYURL;
        $merchantId = MERCHANTID;
        $serviceTypeID = SERVICETYPEID;
        $responseurl = PATH;
        $hash_string = MERCHANTID . SERVICETYPEID . $orderID . $totalAmount . APIKEY;
        $hash = hash('sha512', $hash_string);
        $itemtimestamp = $timesammp;
        $itemid1="acct1";
        $itemid2="acct2";
        $itemid3="acct3";
        $beneficiaryName="KOGI STATE COLLEGE OF NURSING AND MIDWIFERY, OBANGEDE";
        $beneficiaryName2="BLESSEMOL CONSULT";
        //$beneficiaryName3="DATA CENTRE AND ASSOCIATES LTD";
        $beneficiaryAccount="0028908304";
        $beneficiaryAccount2="1015685356";
        //$beneficiaryAccount3="1018058661";
        $bankCode="215";
        $bankCode2="057";
        //$bankCode3="033";
        $beneficiaryAmount = ($totalAmount-500);
        $beneficiaryAmount2 = "500";
        //$beneficiaryAmount3 = "1000";
        $deductFeeFrom = 0;
        $deductFeeFrom2 = 1;
        //$deductFeeFrom3 = 0;

        $content = "{\"serviceTypeId\": \"$serviceTypeID\",
		\"amount\": \"$totalAmount\",
		\"orderId\": \"$orderID\",
		\"payerName\": \"$payerName\",
		\"payerEmail\": \"$payerEmail\",
		\"payerPhone\": \"$payerPhone\",
		\"description\": \"$purpose\",
		\"lineItems\":[
			{\"lineItemsId\":\"$itemid1\",\"beneficiaryName\":\"$beneficiaryName\", \"beneficiaryAccount\":\"$beneficiaryAccount\",\"bankCode\":\"$bankCode\",\"beneficiaryAmount\":\"$beneficiaryAmount\",\"deductFeeFrom\":\"$deductFeeFrom\"},
			
			{\"lineItemsId\":\"$itemid2\",\"beneficiaryName\":\"$beneficiaryName2\", \"beneficiaryAccount\":\"$beneficiaryAccount2\",\"bankCode\":\"$bankCode2\",\"beneficiaryAmount\":\"$beneficiaryAmount2\",\"deductFeeFrom\":\"$deductFeeFrom2\"}
		]}";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $gatewayUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $content,
            CURLOPT_HTTPHEADER => array(
                "Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $json_response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $jsonData = substr($json_response, 7, -1);
        $response = json_decode($jsonData, true);

        $statuscode = $response['statuscode'];
        //return $json_response;
        $statusMsg = $response['status'];
        if($statuscode=='025'){
            $ret['rrr'] = trim($response['RRR']);
            $ret['orderid'] = $orderID;
            $ret['status'] = '';
            $ret['error'] = FALSE;
            $ret['amount'] = $totalAmount;
            $ret['transdate'] = '';
        }
        else{
            $ret['rrr'] = FALSE;
            $ret['orderid'] = FALSE;
            $ret['status'] = '';
            $ret['error'] = "Error Generating RRR - ".$statusMsg;
            $ret['amount'] = $totalAmount;
            $ret['transdate'] = '';
        }
        return $ret;
    }
    //school fee
    private function fetchPayDet($appno, $sess){
        $where = array('matno'=>$appno, 'sess'=>$sess);
        $data = $this->crud_model->get_where($this->paytbl, $where);
        return $data->row_array();
    }
    //accommodation fee
    private function fetchHostelPayDet($appno, $sess){
        $where = array('matno'=>$appno, 'sess'=>$sess);
        $data = $this->crud_model->get_where($this->hpaytbl, $where);
        return $data->row_array();
    }
    //
    private function fetchRRR($appno, $name, $phone, $email, $indigene, $admsess, $sess){
        $where = array('matno'=>$appno, 'sess'=>$sess);
        $data = $this->crud_model->get_where($this->paytbl, $where);
        $data = $data->row_array();
        if($data['rrr']){
            $ret = array('rrr'=>$data['rrr'], 'orderid'=>$data['orderid'], 'error'=>FALSE);
        }
        else{
            //delete existing record
            $where2 = array('matno'=>$appno, 'sess'=>$sess);
            $this->crud_model->delete($this->paytbl, $where2);
            //generate RRR
            $amt = $this->invAmt($indigene, $admsess, $sess, $appno);
            if($amt){
                $amt+=$this->bankcharges;
                $orderid = $this->feecode.$appno.DATE("dmyHis");
                $purpose = $this->purpose.$sess;
                $ret = $this->generateRRR($amt, $name, $email, $phone, $orderid, $purpose);
            }
            else{
                $ret = array('rrr'=>FALSE, 'orderid'=>FALSE, 'error'=>'Invalid invoice amount');
            }
        }
        return $ret;
    }
    //
    private function status($rrr){
        $mert =  MERCHANTID;
        $api_key =  APIKEY;
        $concatString = $rrr . $api_key . $mert;
        $hash = hash('sha512', $concatString);
        //$url 	= CHECKSTATUSURL . '/' . $mert  . '/' . $orderid . '/' . $hash . '/' . 'orderstatus.reg';
        $url 	= CHECKSTATUSURL . '/' . $mert  . '/' . $rrr . '/' . $hash . '/' . 'status.reg';
        // Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);
        $response = json_decode($result, true);
        return $response;
    }
}
