FROM centos:latest
MAINTAINER Carlos Sanchez <carlos@apache.org>

RUN rpm --import https://yum.puppetlabs.com/RPM-GPG-KEY-puppetlabs && \
    rpm -ivh http://yum.puppetlabs.com/puppetlabs-release-el-6.noarch.rpm

# Need to enable centosplus for the image libselinux issue
RUN yum install -y yum-utils
RUN yum-config-manager --enable centosplus

RUN yum update -y
RUN yum install -y puppet tar
RUN puppet module install maestrodev/rvm
RUN puppet module install stahnma/epel

ADD tests/common.yaml /var/lib/hiera/
ADD tests/site.pp /etc/puppet/manifests/

RUN puppet apply /etc/puppet/manifests/site.pp --verbose

CMD ["/bin/bash"]
