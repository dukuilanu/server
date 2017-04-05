;
; BIND data file for local loopback interface
;
$TTL	604800
@	IN	SOA	server.errans.ignorelist.com. pytheaserrans@gmail.com. (
			      6		; Serial
			 604800		; Refresh
			  86400		; Retry
			2419200		; Expire
			 604800	)	; Negative Cache TTL
		NS	server.errans.ignorelist.com.
;

server.errans.ignorelist.com.	A	192.168.1.143
errans.ignorelist.com	A	192.168.1.143
