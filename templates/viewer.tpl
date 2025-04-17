<!DOCTYPE html>
<html>
<head>
    <title>{$fileName|escape}</title>
    <meta charset="UTF-8">
    <script src="http://localhost:8080/web-apps/apps/api/documents/api.js"></script>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        #onlyoffice-container {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div id="onlyoffice-container"></div>

    <script>
        var docEditor = new DocsAPI.DocEditor("onlyoffice-container", {
            width: "100%",
            height: "100%",
            documentType: "word",
            document: {
                fileType: "docx",
                title: "{$fileName|escape:'javascript'}",
                url: "{$fileUrl}"
            },
            editorConfig: {
                mode: "view",
                lang: "es"
            }
        });
    </script>
</body>
</html>
