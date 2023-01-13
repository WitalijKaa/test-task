cp certificate.crt certificate.crt.origin
rm certificate.crt
cat certificate.crt.origin ca_bundle.crt > certificate.crt
