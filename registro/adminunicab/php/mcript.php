<?php 
	//Configuración del algoritmo de encriptación 
	 
	//Debes cambiar esta cadena, debe ser larga y unica 
	//nadie mas debe conocerla 
	$clave  = 'Esto es el proceso de actualizacion de calificaciones en registro academico UNICAB'; 
	 
	//Metodo de encriptación 
	$method = 'aes-256-cbc'; 
	 
	// Puedes generar una diferente usando la funcion $getIV() 
	$iv = base64_decode("OQwran+X9j7eJID9FL4OLg=="); 
	 
	/* 
	Encripta el contenido de la variable, enviada como parametro. 
	*/ 
	 $gen_enc = function ($valor) use ($method, $clave, $iv) { 
		 return openssl_encrypt ($valor, $method, $clave, false, $iv); 
	 }; 
	 
	 /* 
	 Desencripta el texto recibido 
	 */ 
	 $dev_enc = function ($valor) use ($method, $clave, $iv) { 
		 $encrypted_data = base64_decode($valor); 
		 return openssl_decrypt($valor, $method, $clave, false, $iv); 
	 }; 
	 
	 /* 
	 Genera un valor para IV 
	 */ 
	 $getIV = function () use ($method) { 
		 return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($method))); 
	 }; 
	 
	 $campos_ar = 'IPXgQ8tFxZk5g14w37tgwC7HW4za+/bAUQCxkxYGOW+iXcuSeHK08Cr22e8/bKGd586yQLMOiIAzpesH8fhzLckbSQOeggvxPZdm2P/LWMB4L7PG0+pEOW7KQow9LetSpsmTyxZvc88W6fQsGLQXDJ7dCVUzWmt/qHjxGoJtpM8C6z3EpgvWwoNj4yQpXAawS8Qd3HQ+6nijTj1sfmTd210/uNFB05D1Hb8r1xfoR/BXNz3a4oXr1G80+YA9yopQZZTgesEUjE3kwX2uVB3g1EFFhjyj/fyRbHkv0qG3IlHpgHhDtr1TcNbKsH34ekjBh5MsbEqjoujRSDwupo8V12x1pFprNtSlAm1D0MZLtYdkUTJQSmmbGPWLy5KcbYn2EhSyBeQRp8Lz9G9qISCqIKmHYU+xFRAlXdwfJK38FpTDDGgHau6LTuOykX0iUXZlUQ/3/WsMXCAbf7ginzEvJtLQwzqCdoi97WnhaOc9SohFdKVX5oJ0J3TCEUxeSYA1bkCsN7SzoBG8EsuITGUeImuSamZ3abODojRQo2Juaw3E7TY8yl0+mFw9VamoXuoIfCuTjot18H1uEefj4x+Og8sw3GmU9wm2etOwPPoH3OL8BsCnCdROc1jm6Zo1qb/x6il47dMTqhbyMrE0gRqSrHQc2M/Kg8yIryOWniys9lXl7cIk8MBrGs4RYNC+lcgzxRN1WjSsau+SVaIvhZh/OcHEbO0p75tCppsjPH1x4G8clOHulBoQR3S27NU7oucw+Cr9Nz1OEE0A2+IXLsh57w==';
	 $tablas_ar = 'WB/C2tKc1HlR0zFm1y/WtAlfV3WjFMoCbdKxROb12oVWBjyvlsU/UJACikBHtYeoVXEXikitlnoUtvteDbuCxbBtxRqc0rqzLlwCqYg6ApUl5cC9/DNV4qCT7xEArVb882f9MPRO+IP8lub1QgjMIw34xJuB50TNU15U2QkQ3MQ=';
	 $condicion_ar = 'Ziev40KCSnQoZw1Cx/UTJhj0WN7m6gmZyoz0v1Fw/O2DAe/CWlxU5avYbqN/NSZAAVzqY4eeS9x/1PD7jG7g4TK0TrTGkmi4XBZjbdQGSPwZr7Gbiw1YIvpAtgfHVoyiUqPH5u3zVzlipsYx3UqCuZsiikiTpV3ye3ZUaErXWXspkvqtUCegNnXXny0A+hkIKp8Q6QHe+y0rx9vPto5W3CsSlU4GqotCbBKseQ8jk7uxP+9j0DgEjqU9/eMW3FjlkpBqdpH17ZZSuNZtMMozntHgwQTiB8GP0d646p4wzcQ=';
	 $gb_ar = 'kW6PB/yNXFzn5nSU/NYAKg==';
	 
	 $campos_cal = 'OPF1VgdEHyipYbz7hIxjzoxc6SASz6EG+so+cCuRDX9217DwkKJFRUmohcCbPnmI8z/xLT41eNibbacUYA37Qtj7ItGz9qoki6cLbXQkdw66I/7Yf9GMPAJGCO0CCaQQeWsN/5mJDjPvOiV6O1LAq+8ONVMy3l+oKfIkxsy+Qvuh8vxkba3VezOQEsaC54ULeX9s615B5IME/udV3b6PlF0zhQeGYc/eXrdffJH4usUe/zvyNjxN/bMwnn2FjYpAXb88/nY2kAFCNCApWaYhE28cuIroBy/sO4GJ/wjEqSGlG+bLaBPR2zCb2uFLyPFdDDjIcH0gkIEk2njmKPOZuQJWepVPZNJN60wANZppAtbMJa71pIMsF9Z7k7tzwwK5SRFnomVeEQWmaSPcL02RjL7pMv/vXdNjrkRDvA/GjhVxkJDL7UH24If+lRw8flLu8E+7eut2jktPzaBBttr+cynAEJh/lzP8jPLpJnP08bHcbMbUiFGNjp2pd5LnSDNNagU4DMlZwW5m99rQJ6q0Igte5cqH8IE+d1YsYfbulVjQ9SJ0jglBF8sk8b22bYm5T9UaUX+gIKX1OIOmTpL3O92thL41Me38w5Fwmtx8Rg7FRJRUxuxUfHYmrk12m2uvRpkuVCsEjh9fzHx4lasPn+07dP46UM6/RsNDqo6OD312m6ZmGeEQdTduX/bSwQIkvqVpsNC7oJH5rkt32kJoktJSzFCDaHc59E5yPJljPPP0oxy8vHb7cTEkJrYkZKLK8gIPIwSvVnc1nSyl9ip5FhAaiQAoMkwNg+rkBrXBT3ajZ8/s2V1kfOi+/Fuol2ZJOA1OVo0CNb/guec/K8M4FS/UpTs55lUPyGfV30K7WR3PU6A3wFy0OMRS1a01gEKk2Vx+hV0I9oDTQp5rAenEuE1fTEKt/ArQRye2/C/uHp8=';
	 $tablas_cal = 'WB/C2tKc1HlR0zFm1y/WtAlfV3WjFMoCbdKxROb12oVWBjyvlsU/UJACikBHtYeoVXEXikitlnoUtvteDbuCxbBtxRqc0rqzLlwCqYg6ApUl5cC9/DNV4qCT7xEArVb882f9MPRO+IP8lub1QgjMIw34xJuB50TNU15U2QkQ3MQ=';
	 $condicion_cal = '';
	 $ob_cal = 'FCnRVBVhxi/DeLZZ+HzlaKqk4/YOtH00emAD7Yy6HGfd3G8Syp291rWyl1sJA4Pi';
	 
	 $campos_est = 'u4nSqy9GoFVs8o8F9lJgd7EH2++wFGTww31Quphl67AdYPf8mIMCbVj5MK2xWIe8MXWHFQr7hQZni4vxLkaZAwF8uRbBi7KRaU33xd7qToTSeU7ysTP8I9U2yD2UaJE5xt1ushwodEV53H3gJvRf+SSomX6n1uCelimNpQugzSVx/tbQ4SGgF7cFAz7MK0n9EZT2+ji0y2CRgTRIjl/HOmZZkyUssAiL7/SFNn+9oeUCsyEtawhtJMGi85NojgcuBJbk8MOWBsj5VMcbWkRC9QB+LKEHIqg/IPpQqgRUXPzTdHemQzsBlyqpkLetKAOcj5ufBgS01bCr2GI0uibHE8umZ93aedm1SBl8QLgNx7On9i554yKl+6zoCjVz/Q6LCwpM6TQvLsDhm09d6/fUQ/z332FRXK5MSt12tW+61dQewlEY1EN8zLgAqlocDpsMqu5S4hy1gFDKIaaG62xiX6l1Yx6y5BztniNj0fAYiVX/rIowXft7kfWGJWcO5OsAda88p15XklnrBkLWH+naGPSzJGCior21fWrOcqyS7NA3zBYlzk9L8RZnDHdCz3D/eFgkhTGK0jPbGDSfx/6ml6mzPq7EVS6t94bHD0tEgsN+bOJMllDdkf/JaNUf6joq';
	 $tablas_est = 'gggrdTdFmsIJFQrPDZLKWEPBre7RpR3Xknl5mS87rXt+kFbMjZCNzhVONjGFqjYMOLPwFEPSrJ+9T2NHvg6PMrV+CLQn8HT2MKvPnB1WpEMAGZYliqcFebP41OW+L2FpuYw+pZ/n8eueY0ktWW/oUQA097apLQcXAMEWIG6zMM5QT0hxRDTVyd8uRVmhhQnQhon7Y3tofrriqF3BJIHhcMdT/ZDNn/wZMiC3WThEmK5DBwrqMqEQr8VLwBTbFmLPIuoUuAlfGykSHQnJOyU/OXsINXe8o6QjNziKLS24JPrusRqXDsW4C5OJUGKZ7nIHbRG948deRjPIJiVR1+v1noioGoSoMmSo9b1m0fXVvjXPG7ZKjiCM5G4s8LPJgzTT6DA75+7vlHhVfopX90SiOlmy7qYFDRwHL71IOStfWQvNrNXb454Lgc+6r3MrPCJiCYFDuS7CJrXGI6IF9A4GLqVZaFFMAvJLxyKwZfjTKaJQlVUP0FWNnDyomJ81pmPm';
	 $condicion_est = 'qb9D4nUPCeShi3L4HxrMQWm/CX6xYIxERzCM8bsIDNyU4EAQ0TmO919RSDukYWX2GKtv0s7lL0R2oWmCntSBRjChGy/vp/brjjk4UfJin+qFWYVdw0Z/YO8WbOZ69a2AbSJrwK0z+YZb5YgUO9e5oVgQ11FAOKjXcARaQZ7VB5eijNpJOAej4x77QtRg+AHFBN2yyY0W81hCbgu605glK1NBlJuoMF1eQj40HDW+jyx0jB4Emhrws2G+73zW6Lrp856wtZ2S7mWxYLXJ0JCQmkFxMhpt84FYdEMIoTEGeBCdO0ucJWYnr75iUrAgnW5KPjfeK14oQpx5WonhelrIzjqewGpJAh1s9Er6ne38261op4d1luxKdOR0gnNSiNp0rOyQI0h3m7PEqGpMe+3Sb+zepOIpdd7E6+tHVBEQ7BiYGpz9ScRlBxfhzO2zUpX1V9W4o7hqoEfBq0Tp/0H/aJpRi/YFqIl3WY9QZyE/b8PQAqDVE5BtraXq2pKf9+DEJzMdARJ2whPiB9Ad/FJe2MhfQQGwf9BuUfvhIr7HR1+g4r0w0emKW4pyeOKBa8X9rLflgh9dE7NuqQsQ7yHk6J8ioH7c7i00l1N88XBXgZV7qsPq6xSTUsNMvZea5KXuexCAVnUuUwoEuiuqq+B7kbgaAzs4dMVx16f5nY/YMqAfsEv4Csq2Q8P8FZ00UPESYzi7pXm7lVRlQj315joLe7L3He2IzxiXmsavMxTnn4i6iUkmMGWDvuVgsbRfqtgZkXllWPXEwEci+VBQNFh/+FtwuYZS4bb5n1Zaf8bZaioMa+cPKIcCqnufqfGgwpPbZgXst34u/FDz6G9dmWkxkozJUBDA9dCbjBwDd1aS9dU=';
	 $ob_est = '725eA/oAUA9tWPSvcXGFxw==';
	 /****************************************************************************************************************************/
	 
	 $campos_cal_r = 'ECjybm7nTwPtDyOjiPGc9g==';
	 $tablas_cal_r = 'BzcKtNMPt75Mf5PdXU7NnQ==';
	 $condicion_cal_r = '';
	 
	 $notas_upd = 'tyeOnDO5xux6stQNJ1KNzA==';
	 $set_upd = 'Z45NdbOSZSlQGdnEJj2NtjYwbRqXCAwwTVKQ1hteWgE=';
	 $condicion_upd = 'ugjiF90RzA8NRiq5i1wpqZGpLInTgV5/8WlXB9RCRLM=';
	 $condicion_upd_tut = 'ugjiF90RzA8NRiq5i1wpqV0cMm2IdMRhOr/AMVmnl/VPMCE7O+wrhSze9FtV9mRe';
	 $condicion_on_upd = 'ZH2c/caTSvka3JIp0QJUuXqPlbq747oVX+H8KonRTWCjj9tqKmbb42+51VWKMmHzvRocXnRjSCpCOsho7WQOx4lRzag0F0T22k9L8jbyll9Tf3ywGRK7bStNGsEtLXQdlDM/RfjC2s3okL+OkG64+q2ux61vK3R4YkbkgptnqSMUqRFBl5ScmMAg62jWP+1pznbDdxzBKGjROnLmENtj4A==';
	 $condicion_on_upd_tut = 'ZDQlb7YUS3JKi5KJdDq0L/l/6vRypaswn04fzFVkBqcqJhTKNUz9lIAyeisgzbcjNueE5S2FQaNbbYnp6Q60CVZWzxgTNGRXgg+WEiGWYi65+OjiYRcbpSXdSdNhsnJ6Zs/hv4Zi9tLBrvUe8oCY4be/P7spm1ASL1CNKeUVVUQS59Bvz/oWFEBqtQmhAjxS9N7LsEpqomz5iPgJlr9VTQ==';
	 
	 $insert_into_n = 'Rk03IIphtX/yW917n3QgDaK8LMSmP246IPonfTESdfPq92KFN9WgIaqxagBXhnYn/g79MDUMveRF2jcSHDkkJg==';
	 $select_n = 'xdgIekeW96sbIir+OHv+MY+plrY5pITYDlD34l8juuD6bmCqUysL49BhkIJOUsCfEWDi2M5/Sh/niFlMKMYkGBROlmrO+tIZkeEP1SZzb1G925vPUMEjMa9cgiv52GLq8nYrHesloWioNP4OlmyOn275ZGuHKA5bKtkO+BP0TYrL+f5cHr4VUPFHmgxIe0BTTMUVuusQTpPpsZ/04LaI5LE3ejDOAKuAlp3x+BGnr5Dj9n7lESvbkHMNCcLyzM8BYvkzHNbN6PG+27JEwwv2qiW3XKV0sF+ZoLrtIaIlV57bv4T1umq4PNSWBAAz1Wa5JiaKPcNTmbzMTpMwkx5doV1Ho3IGpr/7V8iyHN/+wDHNaQWbr+xfjYVH2nk8ACui';
	 $select_n_tut = 'U3WyOG36UA3S2iWMSe1FxDs0Q9y4lhaVAteQ+km8k3lytx5+NWHZoJSHZV0nevBMckcT72lrC1NVfNMyHTwlv/SQE41lv1BqtKDIakxYUGfP67TXkWb3G6vUbyytlH733+Ixr+3wzsmhTgYpxGlJyzHcRLPgNG/LnrbRTAmDo19+2yjFAqRagLRCUqKKlSGkbNszPFyYRL4OHB42hTeayl+0T+Yzn/yEDuSs5EfjezJ0u05odpOd6mSkP3YOYLn6b7xb1ndYm1vNlPjawUPZYk3pFRFNvlaTFdd3Jjrg4BEfhmyI2OWtjX8IRlOrvxz6uM86G4fmY1dpdflBVt4OoiAOHqtVO8UP9Dgw5QueY6669eCcdOKVXcVSw2eHX3ESWU2jr8kVkMBxIyxIXcXxCWvqcxoRq2zX80xx8WlSeTuAsmvJ/KGu9pKMYFFg9/NyRwFzO0kmF8VMamVEBN+LCy7lObZsbvTjq1xNASlEZvs=';
?>