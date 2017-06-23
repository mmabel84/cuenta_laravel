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
        'privateKey' => 'PuTTY-User-Key-File-2: ssh-rsa
                        Encryption: aes256-cbc
                        Comment: imported-openssh-key
                        Public-Lines: 6
                        AAAAB3NzaC1yc2EAAAADAQABAAABAQDR1Um5pokbBbhYUS1x0e99eP6mPSf9V8QN
                        83UUyGtFew4bxRgjCIqiNX8cmMsjHHw8YiR6xN4d90pNFzx4IvrIFhVcoSYLeLkZ
                        mgRf0oFcVvYm5PjogDpj42QWihX+XQc4N1NaGx/dup8RsLw5Q0f4gEk383Jetg8Z
                        yh3JY85MRZoJOkDm/YRMx3yoIdw+ihbPKXDp1+qVPi23t5vPTXEkyZhvqE6RXBpP
                        GLXex3uN+v/p3qO7rL+pdiHbdeTHd8Kvar8u5edXrMTgv55Nk7GxVsCGMWpbwgQv
                        HB4Eisdtx4GyV1M0V4QLdZdgDLxsuBXnZGe3nj6lRN3CYbiPQxJx
                        Private-Lines: 14
                        4EqOGqunViJTuIIPYCwYgXNFBefVEBxfgaIsKCYocIIB5ZI4K00WPYo7ASoKMFpp
                        xqZjRvv0rd7YxX6hIRwGp5d9o7nPvYdJPsGYz+VmmjJsuLGNvQv0GfPRZE5BRaFP
                        lTsBnJ/C26roPo0cz11XQuQEIs8buMj3fk+1c5plPOXMVAjSZK0xXpWHEPG/dkXe
                        YZF4VF0o+bIHOv//EOyl7ZUW7+TYaTxFVaNtfsEr0odB1vp83n68WlNQ2kCaktjZ
                        SsETbVek3ialVhJ56wDSdzEZZgBP6Uc5PfAhIue8b8f7y4t8z67gEv7LLht7gdNY
                        PwYwUhNep5DmxQiE3RwqYgTH2sOqRKTBQJah6U7gkL+SdgVbQp5C/k8koWOyaBLZ
                        lWWGcOaYftPQhfJSW3rZdvx+0XPk8GjWXYMpVhi4U+EjOteV1+6dVXZJgQlp+F2K
                        xKgYD2ARkl4T6RwC7G+sIXafQhDuNYpnMA9WAfFuncCPUWb6DH2iCM4tkCklxIad
                        NHYv3z9d6A9I6/vHkuWxQMqxL+yJD4fcYrZe69VtlfwFZj0RaZhKZFIg34MploJi
                        abUF0VFVU+rJEdyigt4yhRUMSHnmgJ08lUK5sZv7NW+xLseeySg3P5ag0mqtYUZ+
                        +jpDYxPr96UtINPVtv+8Oc/T5jQBA3zuE0zXCGFcZJ5ElZjhkAtMNSm4DvqHiYOU
                        qdaynjKZJXEf/Sc6psEU+SuCAzCxlBiPXw8bfxYLbd7nUDbtHsxn+AysxMvwv2bH
                        y1o7BzqOosjTOd937Hc3UxwQWMaVCPWemLRXuC7h9bivN3gOQtupfBWXnsqii5u2
                        V7qfQeeX9A9ZZOUg3nhpXIt38eE873rUAjPQz3+vgIubISkFR/3DVAcGopPYOAkO
                        Private-MAC: 720ea9f92b8fcd4ffdc696ea41ed46ed3ac907f4
                        ',
        'root' => '/opt/bitnami/apache2/htdocs/mabel/',
    ],
];
