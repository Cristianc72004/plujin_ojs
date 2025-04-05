{* Botón para abrir el archivo *}
<a href="{url router=PKPApplication::ROUTE_COMPONENT 
    component='plugins.generic.visualizadorDocsPlugin.controllers.VisualizadorDocsHandler' 
    op='fetch' 
    fileId=$fileId}"
    class="pkp_controllers_linkAction pkp_linkaction_view pkp_linkaction_icon_view"
    target="_blank">
    📄 {translate key="plugins.generic.visualizadorDocs.view"}
</a>
