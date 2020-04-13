<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200411174302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C16779488A3C7387');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C16779489D86650F');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C1677948EC470631');
        $this->addSql('DROP INDEX IDX_C16779489D86650F ON lecture');
        $this->addSql('DROP INDEX IDX_C16779488A3C7387 ON lecture');
        $this->addSql('DROP INDEX IDX_C1677948EC470631 ON lecture');
        $this->addSql('ALTER TABLE lecture ADD categorie_id INT NOT NULL, ADD user_id INT NOT NULL, ADD livre_id INT NOT NULL, DROP categorie_id_id, DROP user_id_id, DROP livre_id_id');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C1677948BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C1677948A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C167794837D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_C1677948BCF5E72D ON lecture (categorie_id)');
        $this->addSql('CREATE INDEX IDX_C1677948A76ED395 ON lecture (user_id)');
        $this->addSql('CREATE INDEX IDX_C167794837D925CB ON lecture (livre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C1677948BCF5E72D');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C1677948A76ED395');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C167794837D925CB');
        $this->addSql('DROP INDEX IDX_C1677948BCF5E72D ON lecture');
        $this->addSql('DROP INDEX IDX_C1677948A76ED395 ON lecture');
        $this->addSql('DROP INDEX IDX_C167794837D925CB ON lecture');
        $this->addSql('ALTER TABLE lecture ADD categorie_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, ADD livre_id_id INT NOT NULL, DROP categorie_id, DROP user_id, DROP livre_id');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C16779488A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C16779489D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C1677948EC470631 FOREIGN KEY (livre_id_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_C16779489D86650F ON lecture (user_id_id)');
        $this->addSql('CREATE INDEX IDX_C16779488A3C7387 ON lecture (categorie_id_id)');
        $this->addSql('CREATE INDEX IDX_C1677948EC470631 ON lecture (livre_id_id)');
    }
}
