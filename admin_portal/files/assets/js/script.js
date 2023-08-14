"use strict";
$(document).ready(function() {
    var $window = $(window);
    //add id to main menu for mobile menu start
    var getBody = $("body");
    var bodyClass = getBody[0].className;
    $(".main-menu").attr('id', bodyClass);
    //add id to main menu for mobile menu end

    // card js start
    $(".card-header-right .close-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function() {
            $this.parents('.card').remove();
        }, 800);
    });

    $(".card-header-right .minimize-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("icon-minus").fadeIn('slow');
        $(this).toggleClass("icon-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("icon-maximize");
        $(this).toggleClass("icon-minimize");
    });

    $("#more-details").on('click', function() {
        $(".more-details").slideToggle(500);
    });
    $(".mobile-options").on('click', function() {
        $(".navbar-container .nav-right").slideToggle('slow');
    });
    // card js end
    $.mCustomScrollbar.defaults.axis = "yx";
    $("#styleSelector .style-cont").slimScroll({
        setTop: "10px",
        height:"calc(100vh - 440px)",
    });
    $(".main-menu").mCustomScrollbar({
        setTop: "10px",
        setHeight: "calc(100% - 80px)",
    });
    /*chatbar js start*/

    /*chat box scroll*/
    var a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5,
        color: '#1b8bf9'
    });

    // search
    $("#search-friends").on("keyup", function() {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function() {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    // open chat box
    $('.displayChatbox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat').toggle('slide', options, 500);
    });


    //open friend chat
    $('.userlist-box').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
    });
    //back to main chatbar
    $('.back_chatBox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    // /*chatbar js end*/
    $(".search-btn").on('click', function() {
        $(".main-search").addClass('open');
        $('.main-search .form-control').animate({
            'width': '200px',
        });
    });
    $(".search-close").on('click', function() {
        $('.main-search .form-control').animate({
            'width': '0',
        });
        setTimeout(function() {
            $(".main-search").removeClass('open');
        }, 300);
    });
    $('#mobile-collapse i').addClass('icon-toggle-right');
    $('#mobile-collapse').on('click', function() {
    $('#mobile-collapse i').toggleClass('icon-toggle-right');
    $('#mobile-collapse i').toggleClass('icon-toggle-left');
    });
});
$(document).ready(function() {
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $('.theme-loader').fadeOut('slow', function() {
        $(this).remove();
    });
});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;
    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    $('.full-screen').toggleClass('icon-maximize');
    $('.full-screen').toggleClass('icon-minimize');
}


/* --------------------------------------------------------
        Referral Link CLick Copied
        --------------------------------------------------------   */
        

     function myFunction() {

        var copyText = document.getElementById("referal_link");
        if(copyText.value=="")
        {
          alert("Please generate a referal link first");
        }
        else
        {
          copyText.select();
          document.execCommand("copy");
          $("#copy_btn").html("Copied");
        }

}

function myFunction1() {

        var copyText = document.getElementById("referal_link1");
        if(copyText.value=="")
        {
          alert("Please refresh a page first");
        }
        else
        {
          copyText.select();
          document.execCommand("copy");
          $("#copy_btn1").html("Copied");
        }

}

/* --------------------------------------------------------
        init datatable, Select2, tooltip, popover

        --------------------------------------------------------   */

$(document).ready(function() {
    $('.select2').select2();
    $('.simpletable').DataTable();
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover({
        container: 'body',
        placement: 'right',
        trigger: 'hover',
        html: true
    });

});


/* --------------------------------------------------------
        Generate OTP Code
        --------------------------------------------------------   */

$(document).ready(function () {

    $("#otp_gen").on('click',function(e){
        e.preventDefault();
        var  user_name = $(this).data("uname");
        // console.log(user_name);
        $.ajax({
          url: "include/gen_otp.php",
          data: {'otp': 1, 
          'user_name':user_name},
          type:'POST', 
          beforeSend: function() {
            $('#custom-loader').append(`
                <div class="theme-loader">
                    <div class="ball-scale">
                        <div class='contain'>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                            <div class="ring"><div class="frame"></div></div>
                        </div>
                    </div>
                </div>`);
          },
          complete: function(){
                $('#custom-loader').fadeOut('slow', function() {
                    $(this).remove();
                });

          },
          success: function(response)
          {   
            if(response)
            {
             $('#otp_status').css('display', 'block');   
            console.log(response);
            }
          },
          error: function(response){
            console.log(response);
          }
        });
    });
});



/* --------------------------------------------------------
        Buy Package with Seemise iWallet Cash
        --------------------------------------------------------   */

$(document).ready(function() {
  $(document).on('click', '.buy_pkg', function(event){
      event.preventDefault();
      var pkg_id = $(this).attr("id");
      $.ajax({
        url:"include/select.php?action=viewPackage",
        method:"POST",
        data:{pkg_id:pkg_id},
        success:function(response){
            var res = response.split(" | ");
            // console.log(res);

            if(res[0] == 'Error'){
              $('#pkg_detail').html(res[1]);
              $('#submit_btn').css("display", "none");
            }else{
              $('#pkg_detail').html(response);
              $('#submit_btn').css("display", "block");

            }
        },
        error: function(response){
          alert('Something Whent Wrong Check Console');
          console.log(response);
        }
      });
    });  
});  

$(document).ready(function() {

$(document).on('click', '#submit_btn', function(event){
    event.preventDefault();
        var data = {
          user_id       : $('#user_id').val(),
          pkg_id        : $('#pkg_id').val(),
          pkg_price     : parseInt($('#pkg_price').text()),
          total_price   : parseInt($('#total_price').text())
          };
      $.ajax({
      url:"include/query_smc.php?action=getpkg",
      method:"POST",
      data:data,
      beforeSend: function() {
        $('#pkgModal').hide();
        $('#custom-loader').append(`
            <div class="theme-loader">
                <div class="ball-scale">
                    <div class='contain'>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                        <div class="ring"><div class="frame"></div></div>
                    </div>
                </div>
            </div>`);
      },
      complete: function(){
            $('#custom-loader').fadeOut('slow', function() {
                $(this).remove();
            });

      },
        success:function(response){
        window.location.href="index.php";
        console.log(response)
        },
        error: function (response) {
        alert('Something Whent Wrong Check Console');
        console.log(response);
        }
 
    });
  });
});  


$(document).ready(function() {


    //    Edit Password of user-profile

    $('.edit-info').hide();
    $('.edit-profile-section').hide();

    $('#edit-btn').on('click', function() {
        var b = $(this).find("i");
        var edit_class = b.attr('class');
        if (edit_class == 'icofont icofont-edit') {
            b.removeClass('icofont-edit');
            b.addClass('icofont-close');
            $('.edit-profile-section').hide();
            $('.view-info').hide();
            $('.edit-info').show();
        } else {
            b.removeClass('icofont-close');
            b.addClass('icofont-edit');
            $('.edit-profile-section').hide();
            $('.edit-info').hide();
            $('.view-info').show();

        }
    });

    $('#edit-cancel').on('click', function() {

        var c = $('#edit-btn').find("i");
        c.removeClass('icofont-close');
        c.addClass('icofont-edit');
        $('.view-info').show();
        $('.edit-info').hide();

    });    

    //    Edit information of user-profile
    $('#edit-profile').on('click', function() {
        var b = $(this).find("i");
        var edit_class = b.attr('class');
        if (edit_class == 'icofont icofont-edit') {
            b.removeClass('icofont-edit');
            b.addClass('icofont-close');
            $('.view-info').hide();
            $('.edit-info').hide();            
            $('.edit-profile-section').show();
        } else {
            b.removeClass('icofont-close');
            b.addClass('icofont-edit');
            $('.edit-profile-section').hide();
            $('.edit-info').hide();            
            $('.view-info').show();
        }
    });

    $('#edit-profile-cancel').on('click', function() {

        var c = $('#edit-profile').find("i");
        c.removeClass('icofont-close');
        c.addClass('icofont-edit');
        $('.view-info').show();
        $('.edit-info').hide();        
        $('.edit-profile-section').hide();

    });

});

  
// Show Preloader on form submitting

$(document).ready(function(){
  $("form").on("submit", function(){
    $("#custom-loader").append(`<div class="theme-loader">
                                    <div class="ball-scale">
                                        <div class='contain'>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                            <div class="ring">
                                                <div class="frame"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                            });//submit
                        });//document ready


$(document).ready(function(){
    $('#dsireValue').focusout(function(){
        // alert('Focusout');
        var d_amount = parseInt($(this).val());
        var tax_amount  = d_amount * 0.04;
        var net_amount = d_amount - tax_amount;
        $('#txtValue').val(net_amount);
    });    
});



// lightBox js //

$(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    loadingMessage: `<div class="theme-loader"> <div class="ball-scale"> <div class='contain'> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> <div class="ring"> <div class="frame"></div> </div> </div> </div> </div>`,
                });
            });



    // Reject KYC
     $(document).ready(function(){
        $(document).on("click", ".btn-reject", function () {

        var rejectID = $(this).data('wid');

     $(".modal-body #rejectID").val( rejectID );


     });

     });


// Update Debit/Credit Values 

$(document).ready(function() {

    $('#three').on('keyup', function(e) {
        e.preventDefault();
        var type = $('#two').val();
        if (type === '') {
            alert('Select Type First');
            $("#two").focus();
        }

        var avail_balance = parseInt($('#one').val());
        var dsireValue    = parseInt($('#three').val());
        var updated_value = parseInt($('#four').val());

        if (type == 'Debit' && dsireValue <= avail_balance) {
            
            updated_value = avail_balance - dsireValue;
            $('#four').val(updated_value);
            $('#valError').removeClass('text-danger');
            $('#valError').text('');
            $("button[name='update']").prop('disabled', false);
            $("button[name='update']").css('display', 'block');

        } else if (type == 'Debit' && dsireValue > avail_balance) {

            updated_value = avail_balance - dsireValue;
            $('#four').val(updated_value);
            $('#valError').addClass('text-danger');
            $('#valError').text('Debit amount is greater than your current balance.');
            $("button[name='update']").prop('disabled', true);
            $("button[name='update']").css('display', 'none');
       
        } else if (type == 'Credit') {
            
            updated_value = avail_balance + dsireValue;
            $('#four').val(updated_value);
       
        } else if( (type == 'Credit' || type == 'Debit') && dsireValue === '' ){
            
            // $('#four').val(0);
            if(isNaN(updated_value)){
                console.log(updated_value);
            $('#four').val(updated_value);
                    }
            $('#valError').removeClass('text-danger');
            $('#valError').text('');
            $("button[name='update']").prop('disabled', false);
            $("button[name='update']").css('display', 'block');

        }
    });
});
$(document).ready(function(){

// User Profile Upload //
// $('#OpenImgUpload').click(function(){ 
//     $('#imgupload').trigger('click');
//     $('#img_btn').css('display', 'block');
//     });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
            $('#img_btn').css('display', 'block');
            $('.avatar-edit').find('label').css('display', 'none');
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });
});