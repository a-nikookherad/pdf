# PDF srevice

***this service for convert html file to pdf file***

for initialize this service make sure you set environment's variables

```yaml
PDF_SERVICE_URL=172.19.0.5:8080
PDF_SERVICE_AUTH=arachnys-weaver
```

_this service has three methods_


* set html method:
```php
    $html=view("athenaTemplate.test.index");
    PDF\PDF::setHtml($html);
```


* render method:
```php
    $html=view("athenaTemplate.test.index");
    return response()->make(PDF\PDF::
    setHtml($html)
        ->render(),200,            [
        'content-type' => 'application/pdf'
    ]);
```


* download method:
```php
    $html=view("athenaTemplate.test.index");
    $pdfName="test";
    PDF\PDF::setHtml($html)
        ->download(public_path(sprintf(
            'temp/%s.pdf',
            $pdfName
        )));
```
