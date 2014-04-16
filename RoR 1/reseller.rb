class Reseller < ActiveRecord::Base
  attr_accessible :additional_email, :additional_email2, :additional_name, :additional_name2, :approved, :area_served, :company_address, :company_city, :company_country, :company_name, :company_phone, :company_region, :company_state, :company_website, :company_zip, :contact_email, :contact_name, :contact_title, :distributor, :grandstreamer_id, :sales_contact_email, :sales_contact_name, :tech_contact_email, :tech_contact_name, :terms_and_conditions, :approver
  
  has_many :users, dependent: :destroy
  has_many :leads
  has_many :tickets, :through => :users
  belongs_to :grandstreamer
  belongs_to :approver
  
  before_save { |reseller| reseller.contact_email = contact_email.downcase }
  
  validates :contact_name, presence: true, length: { maximum: 100 }
  validates :company_name, presence: true, length: { maximum: 50 }
  validates :company_region, presence: true
  validates_format_of :company_region, :without => /\A(Please Select a Region)\Z/
  validates_format_of :company_country, :without => /\A(Please Select Country)\Z/
  validates_format_of :company_state, :without => /\A(Please Select State)\Z/
  validates_format_of :area_served, :without => /\A(Please Select Area)\Z/
  validates :company_country, presence: true
  validates :area_served, presence: true
  validates_format_of :area_served, :without => /\A(Please Select Area)\Z/
  validates :company_address, presence: true
  validates :company_city, presence: true
  validates :company_phone, presence: true
  validates :company_website, presence: true
  validates :company_zip, presence: true
  validates :contact_title, presence: true
  validates :distributor, presence: true
  validates :sales_contact_name, presence: true
  validates :tech_contact_name, presence: true
  validates :terms_and_conditions, :acceptance => {:accept => true}
  
  #VALID_EMAIL_REGEX = /\A[\w+\-.]+@[a-z\d\-.]+\.[a-z]+\z/i
	VALID_EMAIL_REGEX = /\A[\w+\.-]+@((?!gmail|hotmail|outlook|aol|yahoo).)[\w\.-]+\.\w{2,8}\z/i
  validates :contact_email, uniqueness: { case_sensitive: false }, presence: true, format: { with: VALID_EMAIL_REGEX }
  
  def self.to_csv(options = {})
    CSV.generate(options) do |csv|
      csv << column_names
      all.each do |reseller|
        csv << reseller.attributes.values_at(*column_names)
      end
    end
  end
  
end
