<?php
return [
    'ExportAPI\\V1\\Rpc\\ExportXls\\Controller' => [
        'POST' => [
            'request' => '{
  "name": "Excel_export",
  "sheets": {
    "1": "test"
  },
  "headers": {
    "1": {
      "test1": {
        "color": "red",
        "type": "number",
        "font-size": "bold"
      },
      "test2": {
        "color": "red",
        "type": "string",
        "border": "thin"
      }
    }
  },
  "data": {
    "1": {
      "test1": {
        "tessssst": {
          "color": "blue",
          "type": "string"
        },
        "tes": {
          "color": "blue",
          "type": "string"
        },
        "tessss": {
          "color": "blue",
          "type": "string"
        }
      },
      "test2": {
        "tessdddssst": {
          "color": "blue",
          "type": "string"
        }
      }
    }
  }
}',
            'description' => 'This RPC method require JSON input in specific format and respond as JSON array with URL dirrecting to uploaded file',
            'response' => '{
  "Excel_export.xls": "http://localhost:8080/download/1"
}',
        ],
        'description' => 'This RPC method require JSON input in specific format and respond as JSON array with URL dirrecting to uploaded file',
    ],
    'ExportAPI\\V1\\Rpc\\SearchFile\\Controller' => [
        'description' => 'This RPC method require file name as GET attribute and response JSON array taht contains all the fiels taht match that name',
        'GET' => [
            'description' => 'This RPC method require file name as GET attribute and response JSON array taht contains all the fiels taht match that name',
            'response' => '{
  "Excel_export.xls": "http://localhost:8080/download/1"
}',
        ],
    ],
    'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => [
        'description' => 'This RPC will decide if user is allowed to download given file and if he is, server the file base on ID that is passed as GET attribute',
        'GET' => [
            'description' => 'This RPC will decide if user is allowed to download given file and if he is, server the file base on ID that is passed as GET attribute',
            'response' => \Zend\Http\Response\Stream::class,
        ],
    ],
];
