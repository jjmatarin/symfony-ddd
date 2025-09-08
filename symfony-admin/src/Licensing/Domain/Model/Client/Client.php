<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventPublisher;
use App\Common\Domain\Model\EntityId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Client
{
    private EntityId $id;
    private string $name;
    private string $description;
    private ClientStatusEnum $status;
    private int $activeLicenseVersion;
    private LicenseTypeEnum $activeLicenseType;
    private Collection $licenses;

    public static function create(EntityId $id, string $name, string $description, LicenseTypeEnum $licenseType, EntityId $productId): self
    {
        return new self($id, $name, $description, $licenseType, $productId);
    }

    private function __construct(EntityId $id, string $name, string $description, LicenseTypeEnum $licenseType, EntityId $productId)
    {
        $this->licenses = new ArrayCollection();

        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->status = ClientStatusEnum::ONBOARDING;
        $this->activeLicenseVersion = 1;
        $this->activeLicenseType = $licenseType;
        $this->createLicense($this->activeLicenseVersion, $licenseType, $productId);

        DomainEventPublisher::getInstance()->publish(new ClientWasCreated($id->get(), $name, $description, $licenseType->value, $productId));
    }

    public function changeLicense(LicenseTypeEnum $licenseType, EntityId $productId): void
    {
        $this->activeLicenseVersion++;
        $this->activeLicenseType = $licenseType;
        $this->createLicense($this->activeLicenseVersion, $licenseType, $productId);
        DomainEventPublisher::getInstance()->publish(new LicenseWasChanged($this->id->get(), $licenseType->value, $productId));
    }

    private function createLicense(int $version, LicenseTypeEnum $licenseType, EntityId $productId): void
    {
        $license = new License($this, $version, $licenseType, $productId);
        $this->licenses->add($license);

    }

    public function update(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;

        DomainEventPublisher::getInstance()->publish(new ClientWasUpdated($this->id->get(), $name, $description));
    }

    public function delete(): void
    {
        $this->status = ClientStatusEnum::DELETED;
        DomainEventPublisher::getInstance()->publish(new ClientWasDeleted($this->id->get()));
    }

    public function getId(): EntityId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): ClientStatusEnum
    {
        return $this->status;
    }

    public function getActiveLicenseType(): LicenseTypeEnum
    {
        return $this->activeLicenseType;
    }

    /**
     * @return LicenseLogItem[]
     */
    public function getLicensesLog(): array
    {
        $result = [];
        /** @var License $license */
        foreach ($this->licenses as $license) {
            $result[] = new LicenseLogItem($license->getDate(), $license->getVersion(), $license->getLicenseType());
        }
        return $result;
    }
}
