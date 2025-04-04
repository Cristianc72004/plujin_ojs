document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('visualizadorBtn').addEventListener('click', function() {
        var fileId = prompt("Introduce el ID del archivo a visualizar:");
        if (fileId) {
            window.open(
                OJS.contextPath + "/$$$call$$$/plugins/generic/visualizadorDocsPlugin/controllers/VisualizadorDocsHandler/fetch?fileId=" + fileId,
                "_blank",
                "width=800,height=600"
            );
        }
    });
});
