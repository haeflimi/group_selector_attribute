<?php
namespace Concrete\Package\GroupSelectorAttribute\Attribute\GroupSelector;

use Concrete\Core\Attribute\Controller as AttributeTypeController;
use Concrete\Core\Attribute\FontAwesomeIconFormatter;
use Concrete\Core\Entity\Attribute\Value\Value\NumberValue;
use Concrete\Core\User\Group\GroupList;
use User;

class Controller extends AttributeTypeController
{
    public function getIconFormatter()
    {
        return new FontAwesomeIconFormatter('users');
    }

    public function getAttributeValueClass()
    {
        return NumberValue::class;
    }

    public function form()
    {
        $value = null;
        if (is_object($this->attributeValue)) {
            $value = $this->getAttributeValue()->getValue();
        }
        if (!$value) {
            if ($this->request->query->has($this->attributeKey->getAttributeKeyHandle())) {
                $value = $this->createAttributeValue((int) $this->request->query->get($this->attributeKey->getAttributeKeyHandle()));
            }
        }
        $this->set('value', $value);
        $this->set('group_list', new GroupList());
    }

    public function getDisplayValue()
    {
        return $this->getPlainTextValue();
    }

    public function getPlainTextValue()
    {
        $gID = $this->getAttributeValue()->getValue();
        $group = Group::getByGroupID($gID);
        if (is_object($group)) {
            return $group->getGroupName();
        }
    }

    public function createAttributeValue($value)
    {
        $av = new NumberValue();
        if ($value instanceof User) {
            $value = $value->getGroupID();
        }
        $av->setValue($value);

        return $av;
    }

    public function createAttributeValueFromRequest()
    {
        $data = $this->post();
        if (isset($data['value'])) {
            return $this->createAttributeValue((int) $data['value']);
        }
    }

    public function importValue(\SimpleXMLElement $akv)
    {
        if (isset($akv->value)) {
            $group = Group::getByUserID($akv->value);
            if (is_object($group)) {
                return $group->getUserID();
            }
        }
    }

    public function exportValue(\SimpleXMLElement $akn)
    {
        if (is_object($this->attributeValue)) {
            $gID = $this->getAttributeValue()->getValue();
            $group = Group::getByUserID($gID);
            $avn = $akn->addChild('value', $group->getGroupID());
        }
    }
}
