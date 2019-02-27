
    </div>
</div>

<footer class="text-center">
    &copy; Copyright 2018 Clothes shop
</footer>


<script src="js/logoscroll.js"></script>
<script>
    function detailsmodal(id) {
        var data = {"id" : id};
        $.ajax({
            url : 'includes/detailsmodal.php',
            method : "post",
            data : data,
            success : function(data){
                $('body').append(data);
                $('#details-modal').modal('toggle');
            },
            error : function(){
                alert("ERROR");
            }
        });
    }
</script>
</body>
</html>