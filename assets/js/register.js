$(document).ready(function(){
    //on click sign up ,hide login and show registeration form
    $("#signup").click(function(){ //click on signup link
        $("#first").slideUp("slow",function(){
            $("#second").slideDown("slow");
        })

    });
    //on click sign in , hide register and show login form
        $("#signin").click(function(){ //click on signin link
        $("#second").slideUp("slow",function(){
            $("#first").slideDown("slow");
        })

    });


})