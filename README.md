# Notes API using Json:API Specification

Notes API te permite realizar un CRUD en tu aplicación Frontend, puedes crear, ver, editar y eliminar notas. La API está desarrollada siguiendo la JSON:API Specification por lo que para realizar solicitudes será necesario complir con las reglas establecidas.

¡Prueba la API! Este es el enlace base <https://notes-api-app.herokuapp.com/api/v1/notes>

Toda request debe de inclir el header `"Content-Type": "application/vnd.api+json"` o de lo contrario será rechazada.

### Operaciones disponibles

* [Fetch notes - GET Request](#fetch-notes-get-request)
* [Create notes - POST Request](#create-notes-post-request)
* [Edit notes - GET Request](#edit-notes-get-request)
* [Update notes - PATCH Request](#update-notes-patch-request)
* [Delete notes - DELETE Request](#delete-notes-delete-request)

## Fetch notes - GET Request

* Obtener todas las notas: `https://notes-api-app.herokuapp.com/api/v1/notes`
* Obtener una nota por id: `https://notes-api-app.herokuapp.com/api/v1/notes/{noteId}`

## Create notes - POST Request

Para poder crear recursos es necesario mandar una solicitud tipo POST a la url `https://notes-api-app.herokuapp.com/api/v1/notes` con la siguiente estructura JSON.

```javascript
{
    "data": {
        "type": "notes",
        "attributes": {
            "title": "Note title",
            "content": "Note content"
        }
    }
}
```

Si la solicitud es aprobada y realizada la API devolverá un código de estado HTTP 201 y devolverá un JSON que contiene los datos de la nota creada.

```javascript
{
    "data": {
        "type" : "notes",
        "id" : "noteId",
        "attributes" : [
            "title" : "Note title",
            "content" : "Note content",
            "created_at" : "2021-05-28T01:23:12.000000Z"
        ],
        "links" : [
            "self" : "https://notes-api-app.herokuapp.com/api/v1/notes/{noteId}"
        ]
    }
}
```

## Edit notes - GET Request

Realiza una petición GET a la url `https://notes-api-app.herokuapp.com/api/v1/notes/{noteId}/edit` para obtener los datos actuales de la nota y poder mostrarlos para edición.

## Update notes - PATCH Request

Realiza una petición PATCH a la url `https://notes-api-app.herokuapp.com/api/v1/notes/{noteId}` para actualizar los datos de la nota, si la petición es procesada con éxito se devolverá un código de estado HTTP 200 y se devolverá un JSON con los datos actualizados.

```javascript
{
    "data": {
        "type": "notes",
        "id": "noteId"
        "attributes": {
            "title": "Note title edited",
            "content": "Note content edited"
        }
    }
}
```

## Delete notes - DELETE Request

Realiza una petición DELETE a la url `https://notes-api-app.herokuapp.com/api/v1/notes/{noteId}` para eliminar la nota con el id propocionado, si la petición es procesada correactamente recibirás un código de estado HTTP 204.

[API URL]: https://notes-api.herokuapp.com/