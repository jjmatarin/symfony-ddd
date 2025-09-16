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
    private string $email;
    private string $description;
    private ClientStatusEnum $status;
    private LicenseTypeEnum $activeLicenseType;
    private EntityId $activeLicenseProductId;
    private int $activeLicenseVersion;
    private Collection $licenses;

    public static function create(
        EntityId $id,
        string $name,
        string $email,
        string $description,
        LicenseTypeEnum $licenseType,
        EntityId $productId,
    ): Client {
        return new Client($id, $name, $email, $description, $licenseType, $productId);
    }

    private function __construct(
        EntityId $id,
        string $name,
        string $email,
        string $description,
        LicenseTypeEnum $licenseType,
        EntityId $productId,
    ) {
        $this->licenses = new ArrayCollection();
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
        $this->activeLicenseType = $licenseType;
        $this->activeLicenseProductId = $productId;
        $this->activeLicenseVersion = 1;
        $this->createLicense($this->activeLicenseVersion, $licenseType, $productId);

        $this->status = ClientStatusEnum::ONBOARDING;

        DomainEventPublisher::getInstance()->publish(new ClientWasCreated(
            $id->get(), $name, $email, $description, $licenseType->value, $productId->get()
        ));
    }

    private function createLicense(int $version, LicenseTypeEnum $licenseType, EntityId $productId): void
    {
        $license = License::create($this, $version, $licenseType, $productId);
        $this->licenses->add($license);
    }

    public function changeLicense(LicenseTypeEnum $licenseType, EntityId $productId): void
    {
        $this->activeLicenseVersion++;
        $this->activeLicenseType = $licenseType;
        $this->activeLicenseProductId = $productId;
        $this->createLicense($this->activeLicenseVersion, $licenseType, $productId);
        DomainEventPublisher::getInstance()->publish(new ClientLicenseWasChanged(
            $this->id->get(), $licenseType->value, $productId->get()
        ));
    }

    public function update(string $name, string $email, string $description): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
        DomainEventPublisher::getInstance()->publish(new ClientWasUpdated(
            $this->id->get(), $name, $email, $description
        ));
    }

    public function activate(): void
    {
        $this->status = ClientStatusEnum::ACTIVE;
        DomainEventPublisher::getInstance()->publish(new ClientWasActivated(
            $this->id->get()
        ));
    }

    public function deactivate(): void
    {
        $this->status = ClientStatusEnum::INACTIVE;
        DomainEventPublisher::getInstance()->publish(new ClientWasDeactivated(
            $this->id->get()
        ));
    }

    public function delete(): void
    {
        $this->status = ClientStatusEnum::DELETED;
        DomainEventPublisher::getInstance()->publish(new ClientWasDeleted(
            $this->id->get()
        ));
    }

    /**
     * @return LicenseLogItem[]
     */
    public function getLicensesLog(): array
    {
        $result = [];
        foreach ($this->licenses as $license) {
            $result[] = new LicenseLogItem($license->getDate(), $license->getVersion(), $license->getType(), $license->getProductId());
        }
        return $result;
    }

    public function getId(): EntityId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
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

    public function getActiveLicenseProductId(): EntityId
    {
        return $this->activeLicenseProductId;
    }

    public function getActiveLicenseVersion(): int
    {
        return $this->activeLicenseVersion;
    }
}
