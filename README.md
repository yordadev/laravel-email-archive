<br/>

<div align="center">
  <a href="https://github.com/YorCreative">
    <img src="./public/readme-logo.png" alt="logo" width="64" height="64"/>
  </a>
</div>
<h2 align="center">Email Archive Laravel TALL Project</h2>
Develop a web application for archiving and viewing email messages using the TALL stack.

## Local Requirements
- Docker

## Getting Started
These instructions will get you a copy of the project up and running testing purposes.

```shell
docker-compose up -d --build

docker exec -it laravel-email-archive composer initSetup 
```

Application available at `http://localhost`.


## API Usage

### Retrieve ALL emails
```shell
curl --location --request GET 'http://localhost/api/email/all'
```

You have the ability to apply parameters to the request for more control over the results:

* limit -- Specifies the maximum number of emails to retrieve.
* sortDir -- Determines the sorting direction of the results.
* offset -- Skips the specified number of emails before starting to return results.

Example Response:
```json
{
    "message": "Successfully retrieved emails.",
    "result": [
        {
            "id": 90,
            "signature": "a69e7106fa645cf3bd732cc25a8122e3",
            "has_attachments": false,
            "created_at": "2024-05-20T06:06:20.000000Z",
            "updated_at": "2024-05-20T06:06:20.000000Z",
            "deleted_at": null,
            "detail": {
                "from": "teammerge@merge.dev",
                "to": "eric.reynolds@huntress.com",
                "subject": "How to use product integration data to build AI features ✨",
                "message_id": "<1715263244124.177a240d-7612-4f3b-afa2-2984d7921fc1@bf03.hubspotemail.net>",
                "updated_at": "2024-05-20T06:06:20.000000Z",
                "deleted_at": null
            }
        }
    ],
    "total": 1
}
```
------
### Retrieve ALL emails
```shell
curl --location --request GET 'http://localhost/api/email/find'
```

Additional Information:
You can apply the following parameter to the request:

* id -- Specifies the ID of the email to retrieve.

Example Response
```json
{
    "message": "Successfully retrieved emails.",
    "result": [
        {
            "id": 90,
            "signature": "a69e7106fa645cf3bd732cc25a8122e3",
            "has_attachments": false,
            "created_at": "2024-05-20T06:06:20.000000Z",
            "updated_at": "2024-05-20T06:06:20.000000Z",
            "deleted_at": null,
            "detail": {
                "from": "teammerge@merge.dev",
                "to": "eric.reynolds@huntress.com",
                "subject": "How to use product integration data to build AI features ✨",
                "message_id": "<1715263244124.177a240d-7612-4f3b-afa2-2984d7921fc1@bf03.hubspotemail.net>",
                "updated_at": "2024-05-20T06:06:20.000000Z",
                "deleted_at": null
            }
        }
    ],
    "total": 1
}
```
---------
### Upload Email cURL
```shell
curl --location 'http://localhost/api/email/upload' \
--header 'accept: application/json' \
--header 'Content-Type: application/json' \
--form 'file=<@"/path/to/your/file"'
```

Additional Information:
The file field is required and must be mimeType: eml.

Example Response
```json
{
    "message": "Email was successfully uploaded",
    "result": {
        "id": 90,
        "signature": "a69e7106fa645cf3bd732cc25a8122e3",
        "has_attachments": false,
        "created_at": "2024-05-20T06:06:20.000000Z",
        "updated_at": "2024-05-20T06:06:20.000000Z",
        "deleted_at": null,
        "detail": {
            "from": "teammerge@merge.dev",
            "to": "eric.reynolds@huntress.com",
            "subject": "How to use product integration data to build AI features ✨",
            "message_id": "<1715263244124.177a240d-7612-4f3b-afa2-2984d7921fc1@bf03.hubspotemail.net>",
            "updated_at": "2024-05-20T06:06:20.000000Z",
            "deleted_at": null
        }
    }
}
```
