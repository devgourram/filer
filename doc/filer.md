Usage
=====

[summary](/README.md)

 - **Api doc**: /api/doc
 - **Section**: Filer

### Get document

#### Request

| route                      | Method | Requirements |
|----------------------------|--------|--------------|
| /documents/download/{uuid} | GET    | uuid: string |

#### Parameters:

| Name          | Type    | Required | Description          |
|---------------|---------|----------|----------------------|
| filter        | string  | false    | image filter         |
| size          | array   | false    | image size           |
| mode          | string  | false    | image crop mode      |
| quality       | integer | false    | image quality        |
| disposition   | string  | false    | document disposition |

### Get document metadata

| route                      | Method | Requirements |
|----------------------------|--------|--------------|
| /documents/{uuid}/metadata | GET    | uuid: string |
 
#### Response

```json
{
    "access": "private",
    "size": 42,
    "name": "image.jpg",
    "type": "PICT",
    "uuid": "ab17401d[...]",
    "hash": "ec3d6aca[...]",
    "mime_type": "image/jpeg",
    "url": "http://[...]/documents/download/ab17401d[...]"
}
```

### Get document and metadata

| route                      | Method | Requirements |
|----------------------------|--------|--------------|
| /documents/{uuid}          | GET    | uuid: string |
 
#### Response

```json
{
    "base64_content": "[...]",
    "access": "private",
    "size": 42,
    "name": "image.jpg",
    "type": "PICT",
    "uuid": "ab17401d[...]",
    "hash": "ec3d6aca[...]",
    "mime_type": "image/jpeg",
    "url": "http://[...]/documents/download/ab17401d[...]"
}
```

#### Sample

Minimal (required):

```json
{
  "uuid": "5e6786875b033d8fa0cf4317b00bac2049d865e9d4c97af8737a4ff1d10db7d5",
}
```

Full:

```json
{
  "uuid": "5e6786875b033d8fa0cf4317b00bac2049d865e9d4c97af8737a4ff1d10db7d5",
  "size": "medium",
  "disposition": "inline"
}
```
