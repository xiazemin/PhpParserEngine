1,classmap
{
    "\\Test\\Test": {
        "file": "file",
        "nameSpace": "\\Test",
        "class": "\\Test\\Test",
        "uses": [
            {
                "use": "\\PhpParser\\Node",
                "as": null
            },
            {
                "use": "\\PhpParser\\NodeVisitorAbstract",
                "as": null
            },
            {
                "use": "\\Called\\CalledClass",
                "as": null
            }
        ],
        "propertys": [
            "_property",
            "property",
            "count"
        ],
        "methods": [
            "getStaticResult",
            "getResult"
        ]
    }
}

2,methodmap
{
    "\\Test\\Test": {
        "getStaticResult": {
            "methodName": "getStaticResult",
            "vars": {
                "o": "\\CalledClass"
            },
            "functions": null,
            "methodCalls": {
                "o": ["get"]
            }
        },
        "getResult": {
            "methodName": "getResult",
            "vars": null,
            "functions": [
                "\\array_keys"
            ],
            "methodCalls": {
                "\\CalledClass": ["getName"],
                "this": ["getStaticResult"],
                "\\self": ["getStaticResult"]
            }
        }
    }
}