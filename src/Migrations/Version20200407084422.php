<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407084422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE critere (id INT AUTO_INCREMENT NOT NULL, categorie_id_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_7F6A80538A3C7387 (categorie_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE critique (id INT AUTO_INCREMENT NOT NULL, lecture_id_id INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, jaime INT DEFAULT NULL, public TINYINT(1) DEFAULT NULL, INDEX IDX_1F950324D4294BB9 (lecture_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE follower (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_B9D609469D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecture (id INT AUTO_INCREMENT NOT NULL, categorie_id_id INT NOT NULL, user_id_id INT NOT NULL, livre_id_id INT NOT NULL, debut_lecture DATE NOT NULL, fin_lecture DATE DEFAULT NULL, statut VARCHAR(255) NOT NULL, indice DOUBLE PRECISION DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, decouverte INT DEFAULT NULL, INDEX IDX_C16779488A3C7387 (categorie_id_id), INDEX IDX_C16779489D86650F (user_id_id), INDEX IDX_C1677948EC470631 (livre_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, livre_id_id INT NOT NULL, theme_id_id INT NOT NULL, INDEX IDX_FCF22AF4EC470631 (livre_id_id), INDEX IDX_FCF22AF4276615B2 (theme_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, imageurl VARCHAR(255) DEFAULT NULL, googleid VARCHAR(255) DEFAULT NULL, isbn VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, lecture_id_id INT NOT NULL, critere_id_id INT NOT NULL, note INT NOT NULL, INDEX IDX_CFBDFA14D4294BB9 (lecture_id_id), INDEX IDX_CFBDFA14C5B6800A (critere_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE critere ADD CONSTRAINT FK_7F6A80538A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE critique ADD CONSTRAINT FK_1F950324D4294BB9 FOREIGN KEY (lecture_id_id) REFERENCES lecture (id)');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D609469D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C16779488A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C16779489D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C1677948EC470631 FOREIGN KEY (livre_id_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF4EC470631 FOREIGN KEY (livre_id_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF4276615B2 FOREIGN KEY (theme_id_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D4294BB9 FOREIGN KEY (lecture_id_id) REFERENCES lecture (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14C5B6800A FOREIGN KEY (critere_id_id) REFERENCES critere (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE critere DROP FOREIGN KEY FK_7F6A80538A3C7387');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C16779488A3C7387');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14C5B6800A');
        $this->addSql('ALTER TABLE critique DROP FOREIGN KEY FK_1F950324D4294BB9');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14D4294BB9');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C1677948EC470631');
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF4EC470631');
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF4276615B2');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE critere');
        $this->addSql('DROP TABLE critique');
        $this->addSql('DROP TABLE follower');
        $this->addSql('DROP TABLE lecture');
        $this->addSql('DROP TABLE liste');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE theme');
    }
}
