document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('visualizadorBtn')) {
        var fileId = e.target.getAttribute('data-file-id');
        window.open(
            OJS.contextPath + "/$$$call$$$/plugins/generic/visualizadorDocsPlugin/controllers/VisualizadorDocsHandler/fetch?fileId=" + fileId,
            "_blank",
            "width=800,height=600"
        );
    }
});
