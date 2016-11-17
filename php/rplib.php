
//
// Create a random subdomain of size $len
//
function genSubdomain($len)
{

     $subdomainCharSet=Array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h',
                             'i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

        $sub='';

        for($i=0;$i<$len;$i++)
        {
                $r=mt_rand(0,count($subdomainCharSet)-1);
                $sub=$sub.$subdomainCharSet[$r];
        }
        return($sub);
}


function Redis_Remove_Port($port)
{
    $redis = new Predis\Client();
    $key = $redis->get("$port");


    logit("redis","Remove key ".$key." on port ".$port);

    //if we have a key lets delete the key and port
    if(strlen($key))
    {
        $redis->del("$key");
        $redis->del("$port");
        $redis->decr("reverse_proxy");
    }
}

