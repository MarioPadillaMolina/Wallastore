(function () {

    let launchModal = document.getElementsByClassName('launchModal');
    if (launchModal) {
        for (var i = 0; i < launchModal.length; i++) {
            launchModal[i].addEventListener('click', sendModal);
        }
    }

    var like = null;
    function sendModal(event) {
        let id = event.target.dataset.id;
        let content = event.target.dataset.content;
        document.getElementById("objId").innerText = id;
        document.getElementById("objContent").innerText = content.substring(0, 50);
        document.getElementById("modalConfirmation").setAttribute("data-id", id);
        if (event.target.dataset.like) { //si el form es de eliminacion de megusta en el show..
            like = event.target.dataset.like;
            document.getElementById("modalConfirmation").innerText = "Dejar de seguir";
        } else {
            document.getElementById("modalConfirmation").innerText = "Eliminar";
        }
    }


    let modalConfirmation = document.getElementById("modalConfirmation");
    if (modalConfirmation) {
        modalConfirmation.addEventListener('click', getModalConfirmation);
    }

    function getModalConfirmation(event) {
        let id = event.target.dataset.id; //data-id
        if (like) {
            var formDelete = document.getElementById('formDeleteLike');
        } else {
            var formDelete = document.getElementById('formDelete');
        }
        formDelete.action += '/' + id;
        formDelete.submit();
    }


    let mensajeModal = document.getElementsByClassName('mensaje');
    if (mensajeModal) {
        for (var i = 0; i < mensajeModal.length; i++) {
            mensajeModal[i].addEventListener('click', function(event) {
                sendMensajeModal(event.target);
            });
        };
    };

    function sendMensajeModal(button) {
        // document.getElementById('mensajeModal').addEventListener('click', function(event) {
                        //reset bucle eventos click
        $('#mensajeModal').off('show.bs.modal').on('show.bs.modal', function (event) {
            // var button = $(this);
             // Button that triggered the modal
            // Extract info from data-* attributes
            var emisorId = button.dataset.emisor;
            var receptorId = button.dataset.receptor;
            var productoId = button.dataset.productoid;
            var productoNombre = button.dataset.productonombre;
            // alert("Emisor: " + emisorId + " Receptor: " + receptorId);
            var modal = $(this);
            modal.find('.modal-title').text('Nuevo mensaje sobre el producto "' + productoNombre + '"');
            modal.find('#emisor_id').val(emisorId);
            modal.find('#receptor_id').val(receptorId);
            modal.find('#producto_id').val(productoId);
            console.log('algo');
            document.getElementById("mensajeForm").reset();
        });
    };
})();