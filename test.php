<?php



$var='https://api.duda.co/api/sites/multiscreen/67f2fa6f';
 $ch = curl_init();
 $headers = array(
    'Accept: application/json',
    'Content-Type: application/json',
'Authorization: Basic MjZlYTc1YmZhMzo1eHM5ZGpua2pxRnA='
    );
curl_setopt($ch, CURLOPT_URL, $var);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$content = curl_exec($ch);
$content = json_decode($content);

print_r($content);


die();

/*echo file_get_contents("/etc/ssl/certs/cacert.pem"); 

die();*/
/*echo phpinfo();
die();*/
   $param = '{
    "settings": {
        "number_of_shards": 1,
        "number_of_replicas": 0,
        "analysis": {
            "filter": {
                "shingle": {
                    "type": "shingle"
                },

                "words_splitter": {
                    "catenate_all": "true",
                    "type": "word_delimiter",
                    "preserve_original": "true"
                }
            },
            "char_filter": {
                "pre_negs": {
                    "type": "pattern_replace",
                    "pattern": "(w+)s+((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))b",
                    "replacement": "~$1 $2"
                },
                "post_negs": {
                    "type": "pattern_replace",
                    "pattern": "b((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))s+(w+)",
                    "replacement": "$1 ~$2"
                }
            },
            "analyzer": {
                "reuters": {
                    "type": "custom",
                    "tokenizer": "standard",
                    "filter": ["lowercase", "stop", "kstem"]
                },
                "words": {
                    "type": "custom",
                    "tokenizer": "keyword",
                    "filter": [
                        "words_splitter"
                    ]
                }

            }
        }
    },
    "mappings": {
        "properties": {
            "code_firme": {
                "type": "text",
                "analyzer": "reuters"
            },
            "rs_comp_search": {
                "type": "text",
                "analyzer": "reuters"
            },
            "rs_comp": {
                "type": "text",
                "analyzer": "reuters"
            },
            "ville": {
                "type": "text",
                "analyzer": "reuters"
            }
        }
    }
}
';

    $header = array(
        "Content-Type: application/json" 
    );
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://elastic:Pm96tlWeFPzhdyBfGGXUrsfl@edicom.es.eu-west-3.aws.elastic-cloud.com/telecontact34/");
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    // curl_close($curl);


if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
    echo$error_msg ;
    // die('here');
}
curl_close($curl);

if (isset($error_msg)) {
    // TODO - Handle cURL error accordingly
}

        print_r($res);
?>



