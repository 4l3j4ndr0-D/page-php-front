
 
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {
        Height: 600,
        onCloseEnd: function() {
           // console.log("Actualizar DOM");
           // location.reload();
        }
    }); 

    var elems = document.querySelectorAll('.fichaPrint');
    elems.forEach(element => {
        element.addEventListener("click", function() {
            //console.log(this.id);
            // $('#myIframe').attr('src', "fichaprint.php?id=" + this.id + "&L=34");
            return false;
        });
    });    
});