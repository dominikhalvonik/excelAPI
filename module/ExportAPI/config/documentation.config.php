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
        ],
    ],
    'ExportAPI\\V1\\Rpc\\DownloadFile\\Controller' => [
        'description' => 'This RPC will decide if user is allowed to download given file and if he is, server the file',
    ],
];
