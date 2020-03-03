<?php include_once('includes/classes/videoDetailForm.php');?>
<?php include_once('includes/header.php');?>


<div class="column">

    <?php

    $FormProvider = new videoDetailFormProvider($con);

    echo $FormProvider->createUploadForm();

   

    ?>

</div>



<script>

    $("form").submit(function(){

        $("#loadingModal").modal("show");
    })

</script>


<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true" data-backdrop = "static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        Please wait while video is processing.
        <img src= "assets/images/91.gif" >
      </div>
      
    </div>
  </div>
</div>

<?php include_once('includes/footer.php');?>