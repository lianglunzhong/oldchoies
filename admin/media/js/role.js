$(function(){
        $("#toolbar tr td a:contains('Edit')").live('click',function(){
                alert('You do not have permission!');
                return false;
        });
        $("#toolbar tr td a:contains('Delete')").live('click',function(){
                alert('You do not have permission!');
                return false;
        });
        $("#toolbar tr td a:contains('Discard')").live('click',function(){
                alert('You do not have permission!');
                return false;
        });
        $("#toolbar tr td a:contains('#Reset')").live('click',function(){
                alert('You do not have permission!');
                return false;
        });
})