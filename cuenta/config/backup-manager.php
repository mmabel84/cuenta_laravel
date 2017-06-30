<?php

return [
    'local' => [
        'type' => 'Local',
        'root' => storage_path('app'),
    ],
    's3' => [
        'type' => 'AwsS3',
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'root'   => '',
    ],
    'gcs' => [
        'type' => 'Gcs',
        'key'    => '',
        'secret' => '',
        'bucket' => '',
        'root'   => '',
    ],
    'rackspace' => [
        'type' => 'Rackspace',
        'username' => '',
        'key' => '',
        'container' => '',
        'zone' => '',
        'endpoint' => 'https://identity.api.rackspacecloud.com/v2.0/',
        'root' => '',
    ],
    'dropbox' => [
        'type' => 'Dropbox',
        'token' => '',
        'key' => '',
        'secret' => '',
        'app' => '',
        'root' => '',
    ],
    'ftp' => [
        'type' => 'Ftp',
        'host' => '',
        'username' => '',
        'password' => '',
        'port' => 21,
        'passive' => true,
        'ssl' => true,
        'timeout' => 30,
        'root' => '',
    ],
    'sftp' => [
        'type' => 'Sftp',
        'host' => 'lab1.advans.mx',
        'username' => 'bitnami',
        'password' => 'Advan$97120',
        'port' => 22,
        'timeout' => 10,
        'privateKey' => '-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAyfJEMChPRnegdtzREe6uRJBBVnckbXuzlbosR5pQqOi6FmnBU/bV7lO0QmLf
QhJQpSAKaDVY2P8nblqMXOFKKMBBsDj3RRx36AH7bBhEq9Z1r/WAqeZiiUSHNW/Rrau+4gfI28TZ
Dd/Ihut3hFddGLFT4KcJH5TP2b3bhiBSCxaQ/i7NyvRNDS8RyPsXtBtXlpijso/b8cwA3zGIP0SG
IvVfsblGW4ThdFP2pzZhv3V/Z3wGB/7scvjbNq21xkyT5vEuKrVLZRdm/k4xQ5ZUx0QPi6HzwB3+
xkrIgCSqFV0WqNEnYML4WMgfTlJSXLaqEKSy3vVQ6UEmV1QNGa9ykwIDAQABAoIBAQDBik7xfGBl
n5aI9B3musIHcd08mdiumMRG9fMj+G/fQZO+kUI4TzM+Qrhae1mOf/EMIAX5U09AQGEw8NTe2wdw
wLjzw9SvRpZgIy4rraJ6sYF+zqGtst+ywJt4ih8A+71n8J/+h8yh8FvFenvDuNq/JIvHnS4wNzVw
b/WouOcIObeOzPVphAznTM8kDzOgAwUKIH2iT50gqnqk8nJQE0oLvBEhe9uT5W4J9IlIhNZ0uHK3
dryKK5ZKxPHgXxMilTSeX6X5xg0l+Lj2por3Sq118W9hqRaM8gJqojvk1HBjGq30JDcw+jYcSaiX
ygLEd5WnCiq64I3hQ3mKc296WVgpAoGBAOQQ6HHw+iXbJqGZDlEwShUkLk7SqVkL3am544l0zz4f
+ILiqmiW3pBm26WJkbwHCByV2AM1PUp40F1f9SPR75ztGWbWPVspl9oyoa5EGR1U526ZtKOoQIsx
PuP1gpxGgXopzE7AvEnjvIsv1bQ27RKfHoO9xMdlMhnQvaIsWRCfAoGBAOKuXbd0SXN8Wmjv0pfu
YLu6MFuORLCvY71qSb0xJ6PUBn2AQXKDYQX7aFWgpgqYbJK5BEEIiFlOss6TcflwCxvQsB14p16P
vQjQYzefvqvxtk/2KwU2KqzVQkEXcbBkNXvJyBLs3c7585KD9OfxZzl8BCD3RLF302IksJnqE9WN
AoGAMJc1nwkTkrs1aNqeRUf/kK+LujmB4Tn4+S9kviWH/hl7rg8y9WOneaagh41e4muxG74FLvHJ
5DMHWc2XAhG5dnrBnbppiiG7e76r2eAiZbBwOo0/AltXnRBZ8OGe+ULAVVHQeLrxouCFjDYd1u6Y
5g3Gx5TH9x+lZACoVoQSWcsCgYADS9fPCCDdTgyehAZC8VN0x2NWoX38N8Cyi24hEyrpZfbmMkxB
Vwm9JYfB3wErHEZP5+LY8z/QVKWi/V/l6awvrlwxQYTlih+MlkMrFuaV54DoLsM3Yy9BriQ1gBrG
Ht7sOuXu6ITdMqNJGSQhj1AZ9OS2egIEtqJbRf9Pbaj2LQKBgQCRuvE+VSHGdbQzJozgSUkxwJAJ
UE/qvuCyGKmQ1hykY6QwDscFcL9hBYXkHsoC3J4kpFV8DTej2WDd8hkWFSlScqr5JBGCQxiFBZVV
70N2PbH3746mVOkST8w98waasXFeiU3Yw7K6bwOM/sW/B2tupeREsqYp+n84BOERlhVwXg==
-----END RSA PRIVATE KEY-----
                        ',
        'root' => '/opt/bitnami/apache2/htdocs/mabel/',
    ],
];
