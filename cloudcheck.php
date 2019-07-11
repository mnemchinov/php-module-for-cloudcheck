<?php

class cloudcheck {

    public $user = 'demo';//Имя пользователя в сервисе cloudcheck
    public $password = 'demo';//Пароль пользователя в сервисе cloudcheck
    public $server = 'cloudcheck.ru';//Адрес сервиса cloudcheck
    public $testmode = true;//Признак тестового (рабочего) запроса. Принимает значения false или true. 
    //                      При значении false производится  запрос реального кредитного отчета и со счета списываются денежные средства. 
    //                      При значении true реального запроса не производится,  система возвращает заранее подготовленный шаблон ответа, 
    //                      денежные средства со счета не списываются.
    public $responsemode = 'xml'; //Формат возвращаемых данных xml/html
    public $httpmode = 'http'; //Режим http/https

    private function sendrequest($url,$txt_request) {
        $headers = array('Content-Type: text/xml; charset=utf-8',
            'user: ' . $this->user,
            'password: ' . $this->password);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $txt_request);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    public function checkfssp($lastName, $firstName, $patronimic, $birthDate, $regionId = '00') {
        //Проверка ФССП
        //lastName	Фамилия запрашиваемого субъекта
        //firstName	Имя запрашиваемого субъекта
        //patronimic	Отчество запрашиваемого субъекта
        //birthDate	Дата рождения запрашиваемого субъекта. Формат: дд.мм.гггг
        //regionId	Двузначный код региона по общероссийскому классификатору объектов административно-территориального деления (ОКАТО).        
        
        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/chfssp/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<personalInfo>';
        $request .= '<lastName>' . $lastName . '</lastName>';
        $request .= '<firstName>' . $firstName . '</firstName>';
        $request .= '<patronimic>' . $patronimic . '</patronimic>';
        $request .= '<birthDate>' . $birthDate . '</birthDate>';
        $request .= '</personalInfo>';
        $request .= '<addressRegistration>';
        $request .= '<regionId>' . $regionId . '</regionId>';
        $request .= '</addressRegistration>';
        $request .= '</persona>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
    public function checkfms($passportSseries, $passportNumber) {
        //Проверка паспорта
        //passportSseries	Серия  паспорта запрашиваемого субъекта. Формат: 4 цифр
        //passportNumber	Номер паспорта запрашиваемого субъекта. Формат: 6 цифр        
        
        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/chfms/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<personalInfo>';
        $request .= '<passportSseries>' . $passportSseries . '</passportSseries>';
        $request .= '<passportNumber>' . $passportNumber . '</passportNumber>';
        $request .= '</personalInfo>';
        $request .= '</persona>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
    public function checkmvd($lastName, $firstName, $patronimic, $birthDate) {
        //Розыск МВД РФ
        //lastName	Фамилия запрашиваемого субъекта
        //firstName	Имя запрашиваемого субъекта
        //patronimic	Отчество запрашиваемого субъекта
        //birthDate	Дата рождения запрашиваемого субъекта. Формат: дд.мм.гггг        
        
        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/chmvd/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<personalInfo>';
        $request .= '<lastName>' . $lastName . '</lastName>';
        $request .= '<firstName>' . $firstName . '</firstName>';
        $request .= '<patronimic>' . $patronimic . '</patronimic>';
        $request .= '<birthDate>' . $birthDate . '</birthDate>';
        $request .= '</personalInfo>';
        $request .= '</persona>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
    public function check115fl($lastName, $firstName, $patronimic, $birthDate) {
        //Поиск в перечне террористов
        //lastName	Фамилия запрашиваемого субъекта
        //firstName	Имя запрашиваемого субъекта
        //patronimic	Отчество запрашиваемого субъекта
        //birthDate	Дата рождения запрашиваемого субъекта. Формат: дд.мм.гггг 
        
        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/ch115fl/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<personalInfo>';
        $request .= '<lastName>' . $lastName . '</lastName>';
        $request .= '<firstName>' . $firstName . '</firstName>';
        $request .= '<patronimic>' . $patronimic . '</patronimic>';
        $request .= '<birthDate>' . $birthDate . '</birthDate>';
        $request .= '</personalInfo>';
        $request .= '</persona>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
    public function getegrul($inn) {
        //Выписка ОГРН
        //inn	ИНН организации/работодателя
        
        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/chinn/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<employment>';
        $request .= '<employerinn>' . $inn . '</employerinn>';
        $request .= '</employment>';
        $request .= '</persona>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
    public function checkoffense($lastName, $firstName, $patronimic, $birthDate, $passportSseries, $passportNumber, $regionId, $city, $street, $house) {
        //Экспертиза КРОНОС: Правонарушения
        //personalInfo	Раздел: Данные контролируемого субъекта	persona.personalInfo	Раздел		Да
        //lastName	Фамилия запрашиваемого субъекта	persona.personalInfo.lastName	Строка		Да
        //firstName	Имя запрашиваемого субъекта	persona.personalInfo.firstName	Строка		Да
        //patronimic	Отчество запрашиваемого субъекта	persona.personalInfo.patronimic	Строка		Да
        //birthDate	Дата рождения запрашиваемого субъекта. Формат: дд.мм.гггг	persona.personalInfo.birthDate	Дата		Да
        //passportSseries	Серия паспорта запрашиваемого субъекта. Формат: 4 цифр	persona.personalInfo.passportSseries	Строка	4	Да
        //passportNumber	Номер паспорта запрашиваемого субъекта. Формат: 6 цифр	persona.personalInfo.passportNumber	Строка	6	Да
        //addressRegistration	Раздел: Адрес регистрации	persona.addressRegistration	Раздел		Да
        //regionId	Двузначный код региона по общероссийскому классификатору объектов административно-территориального деления (ОКАТО).	persona.addressRegistration.regionId	Строка	2	Да
        //city	Адрес регистрации запрашиваемого субъекта: город	persona.addressRegistration.city	Строка		Да
        //street	Адрес регистрации запрашиваемого субъекта: улица	persona.addressRegistration.street	Строка		Да
        //house	Адрес регистрации запрашиваемого субъекта: Номер дома        

        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/cronosv/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<personalInfo>';
        $request .= '<lastName>' . $lastName . '</lastName>';
        $request .= '<firstName>' . $firstName . '</firstName>';
        $request .= '<patronimic>' . $patronimic . '</patronimic>';
        $request .= '<birthDate>' . $birthDate . '</birthDate>';
        $request .= '<passportSseries>' . $passportSseries . '</passportSseries>';
        $request .= '<passportNumber>' . $passportNumber . '</passportNumber>';
        $request .= '</personalInfo>';
        $request .= '<addressRegistration>';
        $request .= '<regionId>' . $regionId . '</regionId>';
        $request .= '<city>' . $city . '</city>';
        $request .= '<street>' . $street . '</street>';
        $request .= '<house>' . $house . '</house>';
        $request .= '</addressRegistration>';
        $request .= '</persona>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
    public function getdossier($lastName, $firstName, $patronimic, $birthDate, $passportSseries, $passportNumber, $regionId, $city, $street, $house) {
        //Экспертиза КРОНОС: Досье
        //personalInfo	Раздел: Данные контролируемого субъекта	persona.personalInfo	Раздел		Да
        //lastName	Фамилия запрашиваемого субъекта	persona.personalInfo.lastName	Строка		Да
        //firstName	Имя запрашиваемого субъекта	persona.personalInfo.firstName	Строка		Да
        //patronimic	Отчество запрашиваемого субъекта	persona.personalInfo.patronimic	Строка		Да
        //birthDate	Дата рождения запрашиваемого субъекта. Формат: дд.мм.гггг	persona.personalInfo.birthDate	Дата		Да
        //passportSseries	Серия паспорта запрашиваемого субъекта. Формат: 4 цифр	persona.personalInfo.passportSseries	Строка	4	Да
        //passportNumber	Номер паспорта запрашиваемого субъекта. Формат: 6 цифр	persona.personalInfo.passportNumber	Строка	6	Да
        //addressRegistration	Раздел: Адрес регистрации	persona.addressRegistration	Раздел		Да
        //regionId	Двузначный код региона по общероссийскому классификатору объектов административно-территориального деления (ОКАТО).	persona.addressRegistration.regionId	Строка	2	Да
        //city	Адрес регистрации запрашиваемого субъекта: город	persona.addressRegistration.city	Строка		Да
        //street	Адрес регистрации запрашиваемого субъекта: улица	persona.addressRegistration.street	Строка		Да
        //house	Адрес регистрации запрашиваемого субъекта: Номер дома  
        
        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/cronos/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<personalInfo>';
        $request .= '<lastName>' . $lastName . '</lastName>';
        $request .= '<firstName>' . $firstName . '</firstName>';
        $request .= '<patronimic>' . $patronimic . '</patronimic>';
        $request .= '<birthDate>' . $birthDate . '</birthDate>';
        $request .= '<passportSseries>' . $passportSseries . '</passportSseries>';
        $request .= '<passportNumber>' . $passportNumber . '</passportNumber>';
        $request .= '</personalInfo>';
        $request .= '<addressRegistration>';
        $request .= '<regionId>' . $regionId . '</regionId>';
        $request .= '<city>' . $city . '</city>';
        $request .= '<street>' . $street . '</street>';
        $request .= '<house>' . $house . '</house>';
        $request .= '</addressRegistration>';
        $request .= '</persona>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
    public function getcrnbki($lastName, $firstName, $patronimic, $birthDate, $passportSseries, $passportNumber, $issueDate) {
        //Кредитный рейтинг НБКИ
        //lastName	Фамилия запрашиваемого субъекта	
        //firstName	Имя запрашиваемого субъекта	
        //patronimic	Отчество запрашиваемого субъекта	
        //birthDate	Дата рождения запрашиваемого субъекта. Формат: дд.мм.гггг	
        //passportSseries	Серия паспорта запрашиваемого субъекта. Формат: 4 цифр	
        //passportNumber	Номер паспорта запрашиваемого субъекта. Формат: 6 цифр	
        //issueDate	Дата выдачи паспорта Формат: дд.мм.гггг	
            
        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/crnbki/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<personalInfo>';
        $request .= '<lastName>' . $lastName . '</lastName>';
        $request .= '<firstName>' . $firstName . '</firstName>';
        $request .= '<patronimic>' . $patronimic . '</patronimic>';
        $request .= '<birthDate>' . $birthDate . '</birthDate>';
        $request .= '<passportSseries>' . $passportSseries . '</passportSseries>';
        $request .= '<passportNumber>' . $passportNumber . '</passportNumber>';
        $request .= '<issueDate>' . $issueDate . '</issueDate>';
        $request .= '</personalInfo>';
        $request .= '</persona>';
        $request .= '<Info>';
        $request .= '<loan>';
        $request .= '<loanSum>1</loanSum>';
        $request .= '</loan>';
        $request .= '</Info>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
    public function getcrbrs($lastName, $firstName, $patronimic, $birthDate, $placeOfBirth, $passportSseries, $passportNumber, $issueDate,$placeOfIssue,$issueAuthority) {
        //Кредитный рейтинг БРС
        //lastName          Фамилия запрашиваемого
        //firstName         Имя запрашиваемого субъекта
        //patronimic        Отчество запрашиваемого
        //birthDate         Дата рождения запрашиваемого субъекта. Формат: дд.мм.гггг	
        //placeOfBirth      Место рождения запрашиваемого субъекта.
        //passportSseries   Серия паспорта запрашиваемого субъекта.
        //passportNumber    Номер паспорта запрашиваемого субъекта. 
        //placeOfIssue      Место выдачи паспорта (максимум 30 символов)
        //issueDate         Дата выдачи паспорта Формат: дд.мм.гггг	
        //issueAuthority    Наименование подразделения, выдавшего паспорт
        
        $url = $this->httpmode . "://" . $this->server . "/ccs/hs/api/crbrs/" . $this->responsemode;

        $request = '<?xml version="1.0" encoding="utf-8"?>';
        $request .= '<request>';
        $request .= '<persona>';
        $request .= '<personalInfo>';
        $request .= '<lastName>' . $lastName . '</lastName>';
        $request .= '<firstName>' . $firstName . '</firstName>';
        $request .= '<patronimic>' . $patronimic . '</patronimic>';
        $request .= '<birthDate>' . $birthDate . '</birthDate>';
        $request .= '<placeOfBirth>' . $placeOfBirth . '</placeOfBirth>';
        $request .= '<passportSseries>' . $passportSseries . '</passportSseries>';
        $request .= '<passportNumber>' . $passportNumber . '</passportNumber>';
        $request .= '<placeOfIssue>' . $placeOfIssue . '</placeOfIssue>';
        $request .= '<issueDate>' . $issueDate . '</issueDate>';
        $request .= '<issueAuthority>' . $issueAuthority . '</issueAuthority>';        
        $request .= '</personalInfo>';
        $request .= '</persona>';
        $request .= '<istest>' . (($this->testmode) ? '1' : '0') . '</istest>';
        $request .= '</request>';
        return $this->sendrequest($url,$request);
    }
}

?>