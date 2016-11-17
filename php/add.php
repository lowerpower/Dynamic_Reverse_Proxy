            


            
            
            // We have a reverse proxy, lets get a random subdomian, or use a subdomain passed
            if(isset($subdomain))
            {
                // Use the passwd Sub
                //echo "use passwd sub $subdomain<br>\n";
            }
            else
            {
                // Generate random subdomain
                $subdomain=genSubdomain(RAND_SUB_DIGITS);
            }

            if($rp_fractional==1)
                $address="$subdomain"."$rp_hostname";
            else
                $address="$subdomain.$rp_hostname";

                //echo "adding redis port $proxy_port to  $address <br>\n";


            // First set the port to subdomain translation
            $redis = new Predis\Client();
            $redis->set("$proxy_port", "$address");
            
            
//
// Create translate subdomain (hardcoded to 7 digits for now)
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

            $redis->expire("$proxy_port", $proxy_lifetime);              // Max expire
            //
            // Now set the subdomain to port translation
            $redis->set("$address", "$proxy_port");
            $redis->expire("$address", $proxy_lifetime);              // Max
            //
            // Incerment the reverse proxy counter
            //
            $redis->incr("reverse_proxy");

