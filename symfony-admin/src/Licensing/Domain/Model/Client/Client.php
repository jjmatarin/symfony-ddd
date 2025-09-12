<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\Model\AggregateEventsTrait;
use App\Common\Domain\Model\EntityId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Client
{
    use AggregateEventsTrait;

    private EntityId $id;
    private string $name;
    private string $description;
    private ClientStatusEnum $status;
    private int $activeLicenseVersion;
    private LicenseTypeEnum $activeLicenseType;
    private Collection $licenses;

    public function __construct()
    {
        $this->licenses = new ArrayCollection();
    }

    public static function create(EntityId $id, string $name, string $description, LicenseTypeEnum $licenseType, EntityId $productId): self
    {
        $client = new self();
        $client->applyEvent(new ClientWasCreated(0, $id->get(), $name, $description, $licenseType->value, $productId));

        return $client;
    }

    public function update(string $name, string $description): void
    {
        $this->applyEvent(new ClientWasUpdated(++$this->playhead, $this->id->get(), $name, $description));
    }

    public function delete(): void
    {
        $this->applyEvent(new ClientWasDeleted(++$this->playhead, $this->id->get()));
    }

    public function changeLicense(LicenseTypeEnum $licenseType, EntityId $productId): void
    {
        $this->applyEvent(new LicenseWasChanged(++$this->playhead, $this->id->get(), $licenseType->value, $productId));
    }

    private function createLicense(int $version, LicenseTypeEnum $licenseType, EntityId $productId): void
    {
        $license = new License($this, $version, $licenseType, $productId);
        $this->licenses->add($license);
    }

    private function applyClientWasCreated(ClientWasCreated $event): void
    {
        $this->id = EntityId::fromString($event->id);
        $this->name = $event->name;
        $this->description = $event->description;
        $this->status = ClientStatusEnum::ONBOARDING;
        $this->activeLicenseVersion = 1;
        $this->activeLicenseType = LicenseTypeEnum::from($event->licenseType);
        $this->createLicense($this->activeLicenseVersion, $this->activeLicenseType, EntityId::fromString($event->productId));
    }

    private function applyClientWasUpdated(ClientWasUpdated $event): void
    {
        $this->name = $event->name;
        $this->description = $event->description;
    }

    private function applyClientWasDeleted(ClientWasDeleted $event): void
    {
        $this->status = ClientStatusEnum::DELETED;
    }

    private function applyChangeLicense(LicenseWasChanged $event): void
    {
        $this->activeLicenseVersion++;
        $this->activeLicenseType = LicenseTypeEnum::from($event->licenseType);
        $this->createLicense($this->activeLicenseVersion, $this->activeLicenseType, EntityId::fromString($event->productId));
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
}
