# csp-hash
Create hashes for CSP-headers

# One page use:
Analyse one page
```
php csp-hash.php 'https://spiro.se'
```


example output:
```
# styles in head: 1
sha256-qbqB8Q3g/c9KEnlre1acOWLd7fPVbSeREIMMaf6wkxk=
# styles in body: 0
# scripts in head: 4
sha256-BfJoHjUd2bukem+dHYVvveMiq2mIXRbOllpJilGHKN0=
sha256-IHi8461ca1DsTfNsopsEWCz/cY01BOUqg+vJeR7P9nU=
sha256-ryv8DcXpXtDY9xq6y+IXO4YRtZMNvIQLR6a2769hAV8=
# scripts in body: 4
sha256-ZoLPmUE984t1ctLy65xUnzPSpSzqqcao/3I8AjOTgNw=
sha256-8KNm+dQAGYbDur5TAQP2NeGj++e8hwKuri0+mzPyYpY=
```

# Hole site use:
Analyes all pages on a site:
```
wget -r --accept html 'https://spiro.se/'
find spiro.se/ -type f | xargs -I F php csp-hash.php F
```

Or to get a summary of the hashes in use:
```
wget -r --accept html 'https://spiro.se/'
find spiro.se/ -type f | xargs -I F php csp-hash.php F | grep -v '#' | sort | uniq -c
```
