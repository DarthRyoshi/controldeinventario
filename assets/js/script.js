// Cambia la URL visible para ocultar index.php
(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get('action');

    if (action) {
        history.replaceState(null, '', '/controlinventario/' + action);
    }
})();
