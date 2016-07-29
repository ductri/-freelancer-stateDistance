<?php 
require('./utils.php');
require('./Polyline.php');

//step1
$cSession = curl_init(); 
//step2
curl_setopt($cSession,CURLOPT_URL,"https://maps.googleapis.com/maps/api/directions/json?origin=Disneyland&destination=Universal+Studios+Hollywood4&key=AIzaSyAq_4lcmeuCIbZ288vbXMnYowGL-PO-lxk");
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_HEADER, false); 
//step3
$result=curl_exec($cSession);
add_avariable('result', $result);
//step4
curl_close($cSession);
//step5
//echo $result;
//console_log($result);

// String to decode
$encoded = "knjmEnjunUbKCfEA?_@]@kMBeE@qIIoF@wH@eFF{@m@I_@?u@j@k@`@EXLTZHh@Y`AgApA{HjJa_@t_@kLnJkFrDeCtBuFxFmIdJmOjPaChDeBlDiAdD}ApGcDxU}@hEmAxD}[tt@yNb\yBdEqFnJqB~DeFxM{Yrs@uKzVoCxEsEtG}BzCkHhKWh@]t@{AxEcClLuDlPwBfHaEzJoInOaBnCiF|K_Oz\{MdZwAbDaKbUiB|CgCnDkDbEiE|FqBlDsLdXqQra@kX|m@aF|KcHtLm@pAaE~JcTxh@}Np\kK~SuMtYwHlPwDnIwDbHcEbGyIhM_FnGyWbXeGlH{BxD_ErIwFpMaBtCcBjAgDtE{BrCcDpC{GjE{KbHkdBjfAgSnLqZdQcb@jV_JrFmE|DwCtDgHxKmRzYeLfQiRnYuB`CgCrBqF`DmExAw`@hIkDdAiEhB_DhB}EhDmJrGeGzFsStSeNjNyCnEoD~FsAtB{AbBuArAoKbKyb@na@mChCeEpCwE~B}CpBiXxVsCvCiPtReBtCiBxDsClE}D|D}EfEmCzCs@fAeBvDyE~M_JnWq@fDcAnFiA~DmCvFMVyAdDkF~OoD~JeCzHi@fC}@jGS~CIjFB|J@j^KdI_AlIaB|G_Nna@yF~PyBvHk@nCy@lDoCvIkMf_@gAbDyDhKkC`G_AzAmCxD_AdAw@n@oApAuDnCwAn@wBn@aBVkCLqCOcCUaCGuHXcCM_Dg@wHs@iACcLD}ERkG|@{EtAiFxBcHvC}AdA{@jAc@x@q@rB[`DoBjSeAjN]rGo@tMLxEKfCo@vCyApDyCvFgHrMqFtJoChE{E`GsPdNeCvBiAjAyAtByP~W_BpDaB|EwBfI_DfM_BnGaE`Oc@fAsEvMiGjS_FzMwBrH_Hd^wBxMoCtRkC~TqBlIiEhKgItSkD|JgDtHiHzLiKlPgDtDsEfDgO~HgDvBcDfD}BzDqGrL_A|AwCfEyAxAkCvBcEfCiUbL_EtDg@l@eC`Fw@rC_@~BWfDIfGKjFYtCcAjEsAhDcDdGuNlY{C~FwDlFaAz@_DtBuDrAcE`AkH~AwNlCmF~AmDzAiGzDgExD{HfJ}FhHwBnB{GbEqA`AsHtHyB~Bo@r@QAKBQN{DlD_DdB}DpCs@x@mAzB_BxAs@t@e@x@u@Ay@s@uA_@kBQw@}D]m@mAg@aBQwB?m@DQZk@`BQr@C\`AnEPd@HNx@dDXv@MJUp@a@lCO`@o@`@";

$points1 = Polyline::decode($encoded);
//=> array(
//     41.90374,-87.66729,41.90324,-87.66728,
//     41.90324,-87.66764,41.90214,-87.66762
//   );
console_log($points1);
// Or list of tuples
$points2 = Polyline::pair($points1);
//=> array(
//     array(41.90374,-87.66729),
//     array(41.90324,-87.66728),
//     array(41.90324,-87.66764),
//     array(41.90214,-87.66762)
//   );
console_log($points2);


 ?>