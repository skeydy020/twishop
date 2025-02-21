$(function(){
    let listStart = $(".list_start .fa");

    listRatingText={
            1 : 'Không thích',
            2 : 'Tạm được',
            3 : 'Bình thường',
            4 : 'Rất tốt',
            5 : 'Tuyệt vời',
    }

    $.each(listStart, function(key,value){
        $(value).mouseover(function(){
            let keyCurrent = key;

            let $this = $(this);
            let number = $this.attr('data-key');
            listStart.removeClass('rating_active');


            $.each(listStart, function(key,value){
                if(keyCurrent >= key){
                    $(this).addClass('rating_active');
                    $("#ratingNumber").val(number);
                }
            });

            $(".list_text").text('').text(listRatingText[number]).show();
        });
    })

    // listStart.mouseover(function(){
    //     let $this = $(this);
    //     let number = $this.attr('data-key');
    //     listStart.removeClass('rating_active');
    //     $.each(listStart, function(key,value){

    //         // if($this.key >= key && $key + 1 <= $this.key + number){
    //         //     $(this).addClass('rating_active');
    //         //     $("#ratingNumber").val(number);
    //         // }

    //         if(key - number >= 0){
    //             $(this).addClass('rating_active');
    //             $("#ratingNumber").val(number);
    //         }
    //     });
    //     $(".list_text").text('').text(listRatingText[number]).show();

    // });

    
    $(".js_rating_action").click(function (event){
        event.preventDefault();

        let $this = $(this);

        if($(`.form_rating_${$this.data('id')}`).hasClass('d-none'))
        {
            $(`.form_rating_${$this.data('id')}`).addClass('active').removeClass('d-none')
        }
    })

    

    $(".form_rating").click(function (event){
        event.preventDefault();

        let $this = $(this);

        if ($this.hasClass('d-none')) {

            $this.addClass('active').removeClass('d-none');
        } else {
            $this.addClass('d-none').removeClass('active');
        }
    })

    $(".rateForm").click(function (event){
        event.stopPropagation();
    })
});