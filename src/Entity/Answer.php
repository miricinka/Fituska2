<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="answers")
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes = 0;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="answers", cascade={"remove"})
     */
    private $question;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reaction", mappedBy="reactionToAnswer", orphanRemoval=true)
     */
    private $reactions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="likedAnswers")
     */
    private $likedByUsers;

    public function __construct()
    {
        $this->reactions = new ArrayCollection();
        $this->likedByUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): self
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions[] = $reaction;
            $reaction->setAuthor($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): self
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getAuthor() === $this) {
                $reaction->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikedByUsers(): Collection
    {
        return $this->likedByUsers;
    }

    public function addLikedByUser(User $likedByUser): self
    {
        if (!$this->likedByUsers->contains($likedByUser)) {
            $this->likedByUsers[] = $likedByUser;
            $likedByUser->addLikedAnswer($this);
        }

        return $this;
    }

    public function removeLikedByUser(User $likedByUser): self
    {
        if ($this->likedByUsers->removeElement($likedByUser)) {
            $likedByUser->removeLikedAnswer($this);
        }

        return $this;
    }

    public function likedByUserCount(User $user) :int {
        $count = 0;
        foreach ($this->likedByUsers as $liked){
            if($liked == $user){
                $count++;
            }
        }
        return $count;
    }
}
