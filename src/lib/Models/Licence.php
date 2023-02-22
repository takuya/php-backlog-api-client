<?php

namespace Takuya\BacklogApiClient\Models;

class Licence extends BaseModel {
  public string $active;
  public string $attachmentLimit;
  public string $attachmentLimitPerFile;
  public string $attachmentNumLimit;
  public string $attribute;
  public string $attributeLimit;
  public string $burndown;
  public string $commentLimit;
  public string $componentLimit;
  public string $fileSharing;
  public string $gantt;
  public string $git;
  public string $issueLimit;
  public string $licenceTypeId;
  public string $limitDate;
  public string $nulabAccount;
  public string $parentChildIssue;
  public string $postIssueByMail;
  public string $projectLimit;
  public string $pullRequestAttachmentLimitPerFile;
  public string $pullRequestAttachmentNumLimit;
  public string $remoteAddress;
  public string $remoteAddressLimit;
  public string $startedOn;
  public string $storageLimit;
  public string $subversion;
  public string $subversionExternal;
  public string $userLimit;
  public string $versionLimit;
  public string $wikiAttachment;
  public string $wikiAttachmentLimitPerFile;
  public string $wikiAttachmentNumLimit;
  public ?string $paymentId;
  public ?string $paymentMonth;
  public ?string $subscribedOn;
  public ?string $trialExpiryDate;
  public ?string $initialCosts;
  public ?string $price;
  public ?string $licenceKey;
  public ?string $nulabAppsIntegration;
  public ?string $issueTemplate;
  public ?string $createdUserId;
  public ?string $created;
  public ?string $updatedUserId;
  public ?string $updated;
}