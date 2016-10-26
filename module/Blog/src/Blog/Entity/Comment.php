<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="article_id", columns={"article_id"})})
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=50, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Attributes({"class":"form-control", "id":"email", "required":"required"})
     * @Annotation\Options({"label":"Email"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"stripTags", "name":"stringTrim"})
     * @Annotation\Validator({"name":"emailAddress", "options":{"encoding":"utf-8", "min":"3", "max":"50"}})
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"class":"form-control", "id":"comment", "required":"required"})
     * @Annotation\Options({"label":"Comment"})
     * @Annotation\Filter({"name":"stripTags", "name":"stringTrim"})
     * @Annotation\Validator({"name":"stringLength", "options":{"encoding":"utf-8", "min":"3"}})
     * @
     */
    private $comment;

    /**
     * @var \Blog\Entity\Article
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     * })
     */
    private $article;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"class":"btn btn-default", "value":" Send "})
     * @Annotation\AllowEmpty({"allowempty":"true"})
     */
    private $submit;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return Comment
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set article
     *
     * @param \Blog\Entity\Article $article
     *
     * @return Comment
     */
    public function setArticle(\Blog\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Blog\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
