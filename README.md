# The problem

Every web project have different binary data to host and handle: images, PDFs, etc. In most cases
those files should be converted in different ways:

* images: resize and format
* PDF to image
* Open office templates to MS Office documents and PDFs

# Solution

This application can host a binary/text data (**Documents**) of a particular content type and
convert it in requested way.

It intended to be deployed at separate hostname as bin._project-hostname_. Also it is recommended
to use cookieless domain for read-only serving of public content.


# Installation

    phing install
    ./scripts/install/plugin.php _plugin_names_to_install_
    cd test/
    phpunit .


# Usage

We desided to use REST interface. Here are the commands.

## POST

Submitting data to the service.

    Url: /
    Data: Document and (optionally) variables to parse if Document is a template
    Return: {id : "_auto_generated_id_string_", contentType: "_content_type_",
        ext: "_standart_file_extension_", length: _file_size_, filename: "_original_file_name_"}


## GET

Getting a **document**.

    Url: /_id_string_._ext_
    Data: no
    Return: Document

**Example**: /12wkr234ser349.pdf - get document "12wkr234ser349" as PDF

Getting a **document** related to some restricted group

    Url: /_auth_group_3_letters_/_id_string_._ext_
    Data: no
    Return: Document

**Example**: /adm/6b12YX.pdf - get document "12wkr234ser349" as PDF

Restriction of /adm/* URIs should be done externally. See section **Authorization** below.


## DELETE

Deleting a **document**.

    Url: /_id_string_
    Data: no
    Return: {}

# Authorization

Authorization should be done externally.

## Example: Restrict all methods except GET with apache web server

    <Directory %PUT_THE_PATH_HERE%/binary/public>

        AuthName "Restricted method"
        AuthType Basic
        AuthBasicProvider file
        AuthUserFile %PUT_THE_PATH_HERE%/passwords

        <LimitExcept GET>
            Require valid-user
        </LimitExcept>

        DirectoryIndex index.php
    </Directory>

# Magic

    magic.mime.mgc version 8 (file version 5.09) is compatible only with php >=5.3.11
    magic.mime.mgc version 7 (file version 5.04) is compatible with php <=5.3.10
    version 7 is included in distribution
    to verify versions, run commands "file -v", "file magic.mime.mgc", "php -v"
