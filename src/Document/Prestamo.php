<?php

namespace App\Document;

use App\Entity\Libro;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

#[ODM\Document]
class Prestamo
{
    #[ODM\Id]
    private $id;

    #[ODM\Field(type: 'int')]
    #[Assert\Positive]
    private int $userId;

    #[ODM\Field(type: 'int')]
    #[Assert\Positive]
    private int $bookId;

    #[ODM\Field(type: 'string')]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $loanDate;

    #[ODM\Field(type: 'string')]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $returnDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Prestamo
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return Prestamo
     */
    public function setUserId(int $userId): Prestamo
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getBookId(): int
    {
        return $this->bookId;
    }

    /**
     * @param int $bookId
     * @return Prestamo
     */
    public function setBookId(int $bookId): Prestamo
    {
        $this->bookId = $bookId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLoanDate(): string
    {
        return $this->loanDate;
    }

    /**
     * @param string $loanDate
     * @return Prestamo
     */
    public function setLoanDate(string $loanDate): Prestamo
    {
        $this->loanDate = $loanDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnDate(): string
    {
        return $this->returnDate;
    }

    /**
     * @param string $returnDate
     * @return Prestamo
     */
    public function setReturnDate(string $returnDate): Prestamo
    {
        $this->returnDate = $returnDate;
        return $this;
    }
}
