<?php
/**
 *
 * Convenience class that provides a simple 
 * interface for creating valid xml responses. 
 *
 * @author: Travis Tillotson <tillotson.travis@gmail.com>
 */
class Route
{
    /**
     * @var DOMDocument $domDoc
     */
    public $domDoc;
    /**
     * @var DOMElement $action
     */
    public $action;
    /**
     * @var DOMElement $params
     */
    public $params;
    
    /**
     *
     * Create new Dom Doc at instantiation
     *
     * @return void
     */
    public function __construct()
    {
        $this->domDoc = new DOMDocument('1.0', 'utf-8');
        $this->action = $this->domDoc->createElement('action');
        $this->params = $this->domDoc->createElement('parameters');
    }
    
    /**
     * Perform a blind transfer
     *
     * @param int $number
     *
     * @return string
     */
    public function transfer($number)
    {
        $app = $this->domDoc->createElement('app', 'transfer');
        $dest = $this->domDoc->createElement('destination', $number);
            
        $this->action->appendChild($app);
        $this->params->appendChild($dest);
        $this->domDoc->appendChild($this->action);
        $this->action->appendChild($this->params);

        return $this->domDoc->saveXML();
    }
    
    /**
     * Route caller to an IVR application
     *
     * @param int $id       | ID of the IVR 
     * @param array $params | custom user paramters
     * @param string $pt    | user defined string
     *
     * @return string
     */
    public function survo($id, $params = array(), $pt = null)
    {
        $app = $this->domDoc->createElement('app', 'survo');
        $id = $this->domDoc->createElement('id', $id);
        
        $this->action->appendChild($app);
        $this->action->appendChild($this->params);
        $this->params->appendChild($id);
        
        $this->setUserParams($params);
        $this->setPt($pt);

        $this->domDoc->appendChild($this->action);

        return $this->domDoc->saveXML();
    }
    
    /**
     *
     * Route to a pre-confgured findme application
     *
     * @param $id | unique ID of configured findme
     *
     * @return string
     */
    public function findme($id)
    {
        $app = $this->domDoc->createElement('app', 'findme');
        $id = $this->domDoc->createElement('id', $id);
        
        $this->action->appendChild($app);
        $this->action->appendChild($this->params);
        $this->params->appendChild($id);
        
        $this->domDoc->appendChild($this->action);

        return $this->domDoc->saveXML();   
    }
    
    /**
     *
     * Dynamically create a findme
     *
     * @param array $numbers | array of transfer numbers
     * @param array $config  | configuration options:
     *  - nextaction: end of list action
     *  - nextactionitem: ID of next action
     *  - simultaneous: amount simultaneous calls
     *  - screen_method: call screening method
     *
     * @return string
     */
    public function findmeList(array $numbers, array $config)
    {
        $app = $this->domDoc->createElement('app', 'findme');
        
        $list = implode('|', $numbers);
        $list = $this->domDoc->createElement('phone_list', $list);
        
        $this->action->appendChild($app);
        $this->action->appendChild($this->params);        
        $this->params->appendChild($list);
        
        if (count($config) > 0) {
            foreach ($config as $k => $v) {
                $this->params->appendChild(new DOMElement($k, $v));
            }
        }
        
        $this->domDoc->appendChild($this->action);

        return $this->domDoc->saveXML();
    }
    
    /**
     *
     * Route to a virtual receptionist
     *
     * @param int $id
     *
     * @return string
     */
    public function virtualReceptionist($id)
    {
        $app = $this->domDoc->createElement('app', 'vr');
        $id = $this->domDoc->createElement('id', $id);
        
        $this->action->appendChild($app);
        $this->action->appendChild($this->params);
        $this->params->appendChild($id);
        
        $this->domDoc->appendChild($this->action);

        return $this->domDoc->saveXML();
    }
    
    /**
     *
     * Route caller to voicemail
     *
     * @param int $id
     *
     * @return void string
     */
    public function voicemail($id)
    {
        $app = $this->domDoc->createElement('app', 'voicemail');
        $id = $this->domDoc->createElement('id', $id);
        
        $this->action->appendChild($app);
        $this->action->appendChild($this->params);
        $this->params->appendChild($id);
        
        $this->domDoc->appendChild($this->action);

        return $this->domDoc->saveXML();
    }
    
    /**
     *
     * Gracefully end a call
     *
     * @return string
     */
    public function hangup()
    {
         $app = $this->domDoc->createElement('app', 'hangup');
         $this->action->appendChild($app);
         $this->domDoc->appendChild($this->action);
         
         return $this->domDoc->saveXML();
    }
    
    /**
     *
     * Set passthrough data
     *
     * @param string $pt
     *
     * @return void
     */
    public function setPt($pt)
    {
        $this->params->appendChild(new DOMElement('p_t', $pt));
    }
    
    /**
     *
     * Helper method for user parameters
     *
     * @param array $params
     *
     * @return void
     */
    public function setUserParams(array $params)
    {
        if (count($params) > 0) {
            $usr_param = $this->params
                ->appendChild(new DOMElement('user_parameters'));    
            
            foreach ($params as $k => $v) {
                $usr_param->appendChild(new DOMElement($k, $v));
            }
        }
    }
}