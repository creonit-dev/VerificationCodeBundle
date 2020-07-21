# VerificationCodeBundle

```yaml
# config/packages/creonit_verification_code.yaml

creonit_verification_code:
    generator:
        config:
            length: 4
    scopes:
        phone:
            key_pattern: '/^\+\d{1,3} *(\(\d{3,4}\)|\d{3,4})([ -]*\d){6,7}$/'
            max_age: 180
            attempt_time: 120

        scope_name:
            max_age: 120
```

```yaml
# config/routes.yaml

api_verification_code:
    resource: '@CreonitVerificationCodeBundle/Controller/'
    type: annotation
```

#`custom code generator`

```php
use Creonit\VerificationCodeBundle\Generator\AbstractCodeGenerator;
use Creonit\VerificationCodeBundle\Generator\Exception\InvalidConfigurationException;

class MyCodeGenerator extends AbstractCodeGenerator
{
    public function generate(string $key)
    {
        return 'code';
    }

    protected function validateConfig(array $config)
    {
        $requiredFields = ['length'];

        if (!empty($undefinedFields = array_diff($requiredFields, array_keys($config)))) {
            throw new InvalidConfigurationException(sprintf('Not defined parameters [%s]', implode(', ', $undefinedFields)));
        }
    }
}
```

```yaml
# config/packages/creonit_verification_code.yaml

creonit_verification_code:
    generator:
        service: '@App\MyCodeGenerator'
        config:
            length: 8
            my_parameter: 'value'
```

#`scope code generator`

```yaml
# config/packages/creonit_verification_code.yaml

creonit_verification_code:
    scopes:
        scope_name:
            generator:
              service: '@App\MyCodeGenerator'
              config:
                  length: 8
                  my_parameter: 'value'
            max_age: 120
```

#`generate code`
```http request
POST https://mydomain.com/verificationCode/{scope_name}
key={key}
```
```php
use Creonit\VerificationCodeBundle\CodeManager;
use Creonit\VerificationCodeBundle\Context\CodeContext;

class PhoneVerificationService
{
    /**
     * @var CodeManager
     */
    protected $codeManager;

    public function __construct(CodeManager $codeManager)
    {
        $this->codeManager = $codeManager;
    }

    /**
     * @param string $key
     *
     * @return \Creonit\VerificationCodeBundle\Model\VerificationCodeInterface
     */
    public function generateCode(string $key)
    {
        $context = new CodeContext($key, 'scope_name');
        
        return $this->codeManager->createCode($context);
    }
}
```

#`verification code`
```http request
PUT https://mydomain.com/verificationCode/{scope_name}
key={key}
code={code}
```
```php
use Creonit\VerificationCodeBundle\CodeManager;
use Creonit\VerificationCodeBundle\Context\CodeContext;

class PhoneVerificationService
{
    /**
     * @var CodeManager
     */
    protected $codeManager;

    public function __construct(CodeManager $codeManager)
    {
        $this->codeManager = $codeManager;
    }

    /**
     * @param string $key
     * @param string $code
     *
     * @return bool
     */
    public function verificationCode(string $key, string $code)
    {
        $context = new CodeContext($key, 'scope_name');
        $context->setCode($code);
        
        return $this->codeManager->verificationCode($context);
    }
}
```



#`events`
```text
Creonit\VerificationCodeBundle\Event\VerificationEvents
```
